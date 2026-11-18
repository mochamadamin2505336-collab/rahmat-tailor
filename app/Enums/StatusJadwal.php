<?php

namespace App\Enums;

enum StatusJadwal: string
{
    case Menunggu = 'menunggu';
    case Dikonfirmasi = 'dikonfirmasi';
    case Selesai = 'selesai';
    case Batal = 'batal';
}
