<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePembayaranDendaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // TODO: Hanya petugas/admin yang bisa akses, sementara return true (di-handle middleware/Gate)
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'id_denda' => 'required|integer|exists:dendas,id',
            'id_petugas' => 'required|integer|exists:petugas,id_petugas',
            'jumlah_bayar' => 'required|numeric|min:0',
            'metode_bayar' => 'sometimes|string|max:20',
            'bukti_bayar' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string|max:1000',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'id_denda.required' => 'Denda wajib diisi.',
            'id_denda.integer' => 'ID denda harus berupa angka.',
            'id_denda.exists' => 'Data denda tidak ditemukan.',
            'id_petugas.required' => 'Petugas wajib diisi.',
            'id_petugas.integer' => 'ID petugas harus berupa angka.',
            'id_petugas.exists' => 'Data petugas tidak ditemukan.',
            'jumlah_bayar.required' => 'Jumlah bayar wajib diisi.',
            'jumlah_bayar.numeric' => 'Jumlah bayar harus berupa angka.',
            'jumlah_bayar.min' => 'Jumlah bayar tidak boleh kurang dari 0.',
            'metode_bayar.max' => 'Metode bayar maksimal 20 karakter.',
            'bukti_bayar.max' => 'Bukti bayar maksimal 255 karakter.',
            'keterangan.max' => 'Keterangan maksimal 1000 karakter.',
        ];
    }
}
