<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PembimbingAkademikResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'user' => $this->user,
            'nama' => $this->nama,
            'fakultas_id' => $this->fakultas_id,
            'fakultas' => $this->fakultas->nama_fakultas,
            'jurusan_id' => $this->jurusan_id,
            'jurusan' => $this->jurusan->nama_jurusan,
            'prodi_id' => $this->prodi_id,
            'prodi' => $this->prodi->nama_prodi,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
