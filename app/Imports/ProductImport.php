<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;

class ProductImport implements WithStartRow, WithChunkReading
{
    use Importable;
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {

    }



    //JADI KITA BATAS DATA YANG AKAN DIGUNAKAN MULAI DARI BARIS KEDUA, KARENA BARIS PERTAMA DIGUNAKAN SEBAGAI HEADING AGAR MEMUDAHKAN ORANG YANG MENGISI DATA PADA FILE EXCEL
    public function startRow(): int
    {
        return 2;
    }

    //KEMUDIAN KITA GUNAKAN chunkSize UNTUK MENGONTROL PENGGUNAAN MEMORY DENGAN MEMBATASI LOAD DATA DALAM SEKALI PROSES
    public function chunkSize(): int
    {
        return 1000;
    }
}
