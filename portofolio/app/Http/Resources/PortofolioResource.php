<?php

namespace App\Http\Resources;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class PortofolioResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // Kalkulasi Semester
        $mahasiswa = new MahasiswaResource($this->mahasiswa);
        $semester = intval($this->tahun) - intval($mahasiswa->angkatan->tahun);
        if (intval($this->semester_id) == 1) {
            $semester = $semester * 2 + 1;
        } else if (intval($this->semester_id) == 2) {
            $semester = $semester * 2;
        }

        // Get Link URL
        $url = Storage::disk('google')->url($this->bukti);

        return [
            'id' => $this->id,
            'mahasiswa' => $mahasiswa,
            'kategori_kegiatan_id' => $this->kategori_kegiatan_id,
            'kategori_kegiatan' => $this->kategori_kegiatan->nama,
            'jenis_kegiatan_id' => $this->jenis_kegiatan_id,
            'jenis_kegiatan' => $this->jenis_kegiatan->nama,
            'ref_point' => $this->jenis_kegiatan->ref_point,
            'valid_point' => $this->valid_point,
            'nama_kegiatan' => $this->nama_kegiatan,
            'penyelenggara' => $this->penyelenggara,
            'tahun' => $this->tahun,
            // 'semester_id' => $this->semester_id,
            // 'semester' => $this->semester->name,
            'semester' => $semester,
            'bukti' => $this->bukti,
            'bukti_url' => $url,
            'status' => $this->status,
            'validator_id' => $this->validator_id,
        ];
    }
}
