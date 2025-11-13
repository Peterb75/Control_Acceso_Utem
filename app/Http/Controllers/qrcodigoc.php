<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class qrcodigoc extends Controller
{
    public function qr_generate(){
        QrCode::generate('coca', '../public/qrcodes/qrcode.svg');
    }
}



