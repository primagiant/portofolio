<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\PortofolioResource;
use App\Models\Mahasiswa;
use App\Models\PembimbingAkademik;
use App\Models\Portofolio;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;

class PortofolioController extends Controller
{
    public function index()
    {
        $mhs_id = User::findOrFail(Auth::user()->id)->mahasiswa->id;
        return PortofolioResource::collection(
            Mahasiswa::find($mhs_id)->portofolio()->paginate(5)
        );
    }

    public function countPortofolio()
    {
        $response = [
            "data" => Portofolio::count(),
        ];
        return response($response, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kategori_kegiatan_id' => ['required'],
            'jenis_kegiatan_id' => ['required'],
            'nama_kegiatan' => ['required', 'string', 'max:191'],
            'penyelenggara' => ['required', 'string', 'max:191'],
            'tahun' => ['required', 'digits_between:4,4', 'numeric'],
            'semester_id' => ['required'],
            'bukti' => ['required', 'file', 'mimes:jpg,png,jpeg,pdf', 'max:2048']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            // Connection to Google Drive API V2
            $client = new \Google_Client();
            $client->setClientId(env('GOOGLE_DRIVE_CLIENT_ID'));
            $client->setClientSecret(env('GOOGLE_DRIVE_CLIENT_SECRET'));
            $client->refreshToken(env('GOOGLE_DRIVE_REFRESH_TOKEN'));
            $client->setAccessToken(env('GOOGLE_DRIVE_ACCESS_TOKEN'));
            $service = new \Google_Service_Drive($client);

            // Create Angkatan Folder Name
            $angkatanFolderName =  User::find(Auth::user()->id)->mahasiswa->angkatan->tahun;

            // Check Angkatan Foldername is exits
            $angkatanDir = Storage::disk('google')->directories();
            foreach ($angkatanDir as $dir) {
                $filename = Storage::disk('google')->getMetadata($dir)['name'];

                if ($filename != $angkatanFolderName) {
                    // Create Angkatan Folder
                    $angkatanFileMetadata = new \Google_Service_Drive_DriveFile(array(
                        'name' => (string) $angkatanFolderName,
                        'parents' => array(env('GOOGLE_DRIVE_FOLDER_ID')),
                        'mimeType' => 'application/vnd.google-apps.folder'
                    ));

                    $angkatanFolderId = $service->files->create($angkatanFileMetadata, array(
                        'fields' => 'id'
                    ));
                    $angkatanFolderId = $angkatanFolderId->id;
                    break;
                } else {
                    $angkatanFolderId = $dir;
                }
            }

            // Check if Folder Not Found
            if (empty($angkatanDir)) {
                // Create Angkatan Folder
                $angkatanFileMetadata = new \Google_Service_Drive_DriveFile(array(
                    'name' => (string) $angkatanFolderName,
                    'parents' => array(env('GOOGLE_DRIVE_FOLDER_ID')),
                    'mimeType' => 'application/vnd.google-apps.folder'
                ));

                $angkatanFolderId = $service->files->create($angkatanFileMetadata, array(
                    'fields' => 'id'
                ));
                $angkatanFolderId = $angkatanFolderId->id;
            }

            // Create NIM Folder Name
            $nimFolderName =  User::find(Auth::user()->id)->mahasiswa->nim;

            // Check NIM Foldername is exits
            $nimDir = Storage::disk('google')->directories($angkatanFolderId);
            foreach ($nimDir as $dir) {
                $dirr = explode('/', $dir);
                $filename = Storage::disk('google')->getMetadata($dirr[1])['name'];

                if ($filename != $nimFolderName) {
                    // Create NIM Folder
                    $nimFileMetadata = new \Google_Service_Drive_DriveFile(array(
                        'name' => (string) $nimFolderName,
                        'parents' => array($angkatanFolderId),
                        'mimeType' => 'application/vnd.google-apps.folder'
                    ));

                    $nimFolderId = $service->files->create($nimFileMetadata, array(
                        'fields' => 'id'
                    ));
                    $nimFolderId = $nimFolderId->id;
                    break;
                } else {
                    $nimFolderId = $dirr[1];
                }
            }

            if (empty($nimDir)) {
                // Create NIM Folder
                $nimFileMetadata = new \Google_Service_Drive_DriveFile(array(
                    'name' => (string) $nimFolderName,
                    'parents' => array($angkatanFolderId),
                    'mimeType' => 'application/vnd.google-apps.folder'
                ));

                $nimFolderId = $service->files->create($nimFileMetadata, array(
                    'fields' => 'id'
                ));
                $nimFolderId = $nimFolderId->id;
            }

            // Get Filename
            $fileExtension = $request->file('bukti')->extension();
            $fileName = time() . uniqid() . '.' . $fileExtension;

            // Get MimeType
            if ($fileExtension == 'pdf') {
                $mimeType = 'application/pdf';
            } else if ($fileExtension == 'jpg' || $fileExtension == 'jpeg') {
                $mimeType = 'image/jpeg';
            } else if ($fileExtension == 'png') {
                $mimeType = 'image/png';
            }

            // Upload File
            $fileMetadata = new \Google_Service_Drive_DriveFile(array(
                'name' => $fileName,
                'parents' => array($nimFolderId),
            ));

            $file = file_get_contents($request->file('bukti'));

            $fileArray = $service->files->create($fileMetadata, array(
                'data' => $file,
                'mimeType' => $mimeType,
                'uploadType' => 'multipart',
                'fields' => 'id'
            ));

            // Get File Id
            $fileId = $fileArray->id;

            // Simpan di Database
            $portofolio = Portofolio::create([
                'mahasiswa_id' => User::find(Auth::user()->id)->mahasiswa->id,
                'kategori_kegiatan_id' => $request->kategori_kegiatan_id,
                'jenis_kegiatan_id' => $request->jenis_kegiatan_id,
                'nama_kegiatan' => $request->nama_kegiatan,
                'penyelenggara' => $request->penyelenggara,
                'tahun' => $request->tahun,
                'semester_id' => $request->semester_id,
                'bukti' => $fileId,
                'valid_point' => '0',
            ]);

            $result = new PortofolioResource(
                Portofolio::findOrFail($portofolio->id)
            );

            $response = [
                'message' => "Portofolio Data created",
                'data' => $result,
            ];
            return response()->json($response, Response::HTTP_CREATED);
        } catch (QueryException $e) {
            return response()->json([
                'message' => "Failed " . $e->errorInfo,
            ]);
        }
    }

    public function show($id)
    {
        return new PortofolioResource(Portofolio::findOrFail($id));
    }

    public function byNim($nim)
    {
        $mhs_id = Mahasiswa::where('nim', $nim)->first()->id;
        $response = [
            'message' => "Portofolio Have Been Updated",
            'data' => [
                'perluValidasi' => PortofolioResource::collection(
                    Mahasiswa::find($mhs_id)->portofolio()->where('status', 0)->get()
                ),
                'sudahValidasi' => PortofolioResource::collection(
                    Mahasiswa::find($mhs_id)->portofolio()->paginate(5)->where('status', 1)
                ),
            ],
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    public function update(Request $request, $id)
    {
        $portofolio = Portofolio::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'kategori_kegiatan_id' => ['required'],
            'jenis_kegiatan_id' => ['required'],
            'nama_kegiatan' => ['required', 'string', 'max:191'],
            'penyelenggara' => ['required', 'string', 'max:191'],
            'tahun' => ['required', 'digits_between:4,4', 'numeric'],
            'semester_id' => ['required'],
            'bukti' => ['file', 'mimes:jpg,png,jpeg,pdf', 'max:2048'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            if ($request->file('bukti')) {
                // Remove Previous File
                Storage::disk('google')->delete($portofolio->bukti);

                // Connection to Google Drive API V2
                $client = new \Google_Client();
                $client->setClientId(env('GOOGLE_DRIVE_CLIENT_ID'));
                $client->setClientSecret(env('GOOGLE_DRIVE_CLIENT_SECRET'));
                $client->refreshToken(env('GOOGLE_DRIVE_REFRESH_TOKEN'));
                $client->setAccessToken(env('GOOGLE_DRIVE_ACCESS_TOKEN'));
                $service = new \Google_Service_Drive($client);

                // Create Angkatan Folder Name
                $angkatanFolderName =  User::find(Auth::user()->id)->mahasiswa->angkatan->tahun;

                // Check Angkatan Foldername is exits
                $angkatanDir = Storage::disk('google')->directories();
                foreach ($angkatanDir as $dir) {
                    $filename = Storage::disk('google')->getMetadata($dir)['name'];

                    if ($filename != $angkatanFolderName) {
                        // Create Angkatan Folder
                        $angkatanFileMetadata = new \Google_Service_Drive_DriveFile(array(
                            'name' => (string) $angkatanFolderName,
                            'parents' => array(env('GOOGLE_DRIVE_FOLDER_ID')),
                            'mimeType' => 'application/vnd.google-apps.folder'
                        ));

                        $angkatanFolderId = $service->files->create($angkatanFileMetadata, array(
                            'fields' => 'id'
                        ));
                        $angkatanFolderId = $angkatanFolderId->id;
                        break;
                    } else {
                        $angkatanFolderId = $dir;
                    }
                }

                // Check if Folder Not Found
                if (empty($angkatanDir)) {
                    // Create Angkatan Folder
                    $angkatanFileMetadata = new \Google_Service_Drive_DriveFile(array(
                        'name' => (string) $angkatanFolderName,
                        'parents' => array(env('GOOGLE_DRIVE_FOLDER_ID')),
                        'mimeType' => 'application/vnd.google-apps.folder'
                    ));

                    $angkatanFolderId = $service->files->create($angkatanFileMetadata, array(
                        'fields' => 'id'
                    ));
                    $angkatanFolderId = $angkatanFolderId->id;
                }

                // Create NIM Folder Name
                $nimFolderName =  User::find(Auth::user()->id)->mahasiswa->nim;

                // Check NIM Foldername is exits
                $nimDir = Storage::disk('google')->directories($angkatanFolderId);
                foreach ($nimDir as $dir) {
                    $dirr = explode('/', $dir);
                    $filename = Storage::disk('google')->getMetadata($dirr[1])['name'];

                    if ($filename != $nimFolderName) {
                        // Create NIM Folder
                        $nimFileMetadata = new \Google_Service_Drive_DriveFile(array(
                            'name' => (string) $nimFolderName,
                            'parents' => array($angkatanFolderId),
                            'mimeType' => 'application/vnd.google-apps.folder'
                        ));

                        $nimFolderId = $service->files->create($nimFileMetadata, array(
                            'fields' => 'id'
                        ));
                        $nimFolderId = $nimFolderId->id;
                        break;
                    } else {
                        $nimFolderId = $dirr[1];
                    }
                }

                if (empty($nimDir)) {
                    // Create NIM Folder
                    $nimFileMetadata = new \Google_Service_Drive_DriveFile(array(
                        'name' => (string) $nimFolderName,
                        'parents' => array($angkatanFolderId),
                        'mimeType' => 'application/vnd.google-apps.folder'
                    ));

                    $nimFolderId = $service->files->create($nimFileMetadata, array(
                        'fields' => 'id'
                    ));
                    $nimFolderId = $nimFolderId->id;
                }

                // Get Filename
                $fileExtension = $request->file('bukti')->extension();
                $fileName = time() . uniqid() . '.' . $fileExtension;

                // Get MimeType
                if ($fileExtension == 'pdf') {
                    $mimeType = 'application/pdf';
                } else if ($fileExtension == 'jpg' || $fileExtension == 'jpeg') {
                    $mimeType = 'image/jpeg';
                } else if ($fileExtension == 'png') {
                    $mimeType = 'image/png';
                }

                // Upload File
                $fileMetadata = new \Google_Service_Drive_DriveFile(array(
                    'name' => $fileName,
                    'parents' => array($nimFolderId),
                ));

                $file = file_get_contents($request->file('bukti'));

                $fileArray = $service->files->create($fileMetadata, array(
                    'data' => $file,
                    'mimeType' => $mimeType,
                    'uploadType' => 'multipart',
                    'fields' => 'id'
                ));

                // Get File Id
                $bukti = $fileArray->id;
            } else {
                $bukti = $portofolio->bukti;
            }
            $portofolio->update([
                'mahasiswa_id' => User::find(Auth::user()->id)->mahasiswa->id,
                'kategori_kegiatan_id' => $request->kategori_kegiatan_id,
                'jenis_kegiatan_id' => $request->jenis_kegiatan_id,
                'nama_kegiatan' => $request->nama_kegiatan,
                'penyelenggara' => $request->penyelenggara,
                'tahun' => $request->tahun,
                'bukti' => $bukti,
                'semester_id' => $request->semester_id,
                'valid_point' => '0',
                'status' => '0',
            ]);

            $result = new PortofolioResource(
                Portofolio::findOrFail($portofolio->id)
            );

            $response = [
                'message' => "Portofolio Have Been Updated",
                'data' => $result,
            ];
            return response()->json($response, Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                'message' => "Failed " . $e->errorInfo,
            ]);
        }
    }

    public function validasi(Request $request, $id)
    {
        dd(Auth::user()->id);
        $portofolio = Portofolio::findOrFail($id);
        $request->validate([
            'valid_point' => ['required', 'numeric'],
        ]);

        try {
            $portofolio->valid_point = $request->valid_point;
            $portofolio->status = 1;
            $portofolio->validator_id = Auth::user()->id;
            $portofolio->save();
            $response = [
                'message' => "Portofolio Tervalidasi",
            ];
            return response()->json($response, Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                'message' => "Failed " . $e->errorInfo,
            ]);
        }
    }

    public function destroy($id)
    {
        $portofolio = Portofolio::findOrFail($id);
        try {
            Storage::disk('google')->delete($portofolio->bukti);
            $portofolio->delete();
            $response = [
                'message' => "Portofolio Deleted",
            ];
            return response()->json($response, Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                'message' => "Failed " . $e->errorInfo,
            ]);
        }
    }
}
