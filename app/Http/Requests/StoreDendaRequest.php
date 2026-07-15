<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDendaRequest extends FormRequest
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
            'id_pengembalian' => 'nullable|exists:pengembalians,id_pengembalian',
            'id_anggota' => 'required|integer|exists:anggotas,id_anggota',
            'total_denda' => 'required|numeric|min:0',
            'sisa_denda' => 'required|numeric|min:0',
            'status_denda' => 'sometimes|string|max:20',
            'tanggal_dikenakan' => 'required|date',
            'tanggal_jatuh_tempo' => 'nullable|date|after_or_equal:tanggal_dikenakan',
            'alasan_denda' => 'nullable|string|max:1000',
            'created_by' => 'nullable|integer|exists:petugas,id_petugas',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'id_pengembalian.exists' => 'Data pengembalian tidak valid atau tidak ditemukan.',
            'id_anggota.required' => 'Anggota wajib diisi.',
            'id_anggota.integer' => 'ID anggota harus berupa angka.',
            'id_anggota.exists' => 'Data anggota tidak ditemukan.',
            'total_denda.required' => 'Total denda wajib diisi.',
            'total_denda.numeric' => 'Total denda harus berupa angka.',
            'total_denda.min' => 'Total denda tidak boleh kurang dari 0.',
            'sisa_denda.required' => 'Sisa denda wajib diisi.',
            'sisa_denda.numeric' => 'Sisa denda harus berupa angka.',
            'sisa_denda.min' => 'Sisa denda tidak boleh kurang dari 0.',
            'status_denda.max' => 'Status denda maksimal 20 karakter.',
            'tanggal_dikenakan.required' => 'Tanggal dikenakan wajib diisi.',
            'tanggal_dikenakan.date' => 'Format tanggal dikenakan tidak valid.',
            'tanggal_jatuh_tempo.date' => 'Format tanggal jatuh tempo tidak valid.',
            'tanggal_jatuh_tempo.after_or_equal' => 'Tanggal jatuh tempo harus sama atau setelah tanggal dikenakan.',
            'alasan_denda.max' => 'Alasan denda maksimal 1000 karakter.',
            'created_by.exists' => 'Data petugas tidak valid.',
        ];
    }
}
