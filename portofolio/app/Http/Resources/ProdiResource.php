<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProdiResource extends JsonResource
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
            'fakultas_id' => $this->fakultas_id,
            'jurusan_id' => $this->jurusan_id,
            'nama_prodi' => $this->nama_prodi,
            'jurusan' => $this->jurusan->nama_jurusan,
            'fakultas' => $this->fakultas->nama_fakultas,
            'deskripsi' => $this->deskripsi,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
