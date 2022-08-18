<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MahasiswaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if (empty($this->pembimbing_akademik)) {
            $pa = [
                'nama' => 'Data Belum Ada'
            ];
        } else {
            $pa = $this->pembimbing_akademik;
        }
        $totalSkor = 0;
        foreach ($this->portofolio as $p) {
            $totalSkor += $p->valid_point;
        }
        return [
            'id' => $this->id,
            'nim' => $this->nim,
            'user_id' => $this->user_id,
            'nama' => $this->nama,
            'pembimbing_akademik' => $pa['nama'],
            'angkatan' => $this->angkatan->tahun,
            'fakultas' => $this->fakultas->nama_fakultas,
            'jurusan' => $this->jurusan->nama_jurusan,
            'prodi' => $this->prodi->nama_prodi,
            'totalSkor' => $totalSkor,
            'status' => $this->status,
        ];
    }
}
