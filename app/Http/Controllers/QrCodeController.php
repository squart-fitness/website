<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use QrCode;
use App\Http\Controllers\QRcode\QrCodeManager;
use App\Models\QRcode as QrCodeModel;

class QrCodeController extends Controller
{
    public function show(){
    	$code =  QrCode::size(250)
    					->errorCorrection('H')
    					->format('png')
    					->merge('/../public_html/assets/img/logo_on_qr.png')
    					->generate('Content of qr code');
			        // ->format('png')
			        // ->generate('Content of qr code will go here', ('../public_html/assets/img/qr_temp.png'));

		// return QrCode::generate('e');

        $codeNum = QrCodeModel::select('code_number', 'qr_unique_number')->get();
		return view('test.qr-code')->with(['qr_code'=> $code, 'code_number' => $codeNum]);
    }

    public function output(Request $request){
        $code =  QrCode::size(250)
                        ->errorCorrection('H')
                        ->format('png')
                        ->merge('/../public_html/assets/img/logo_on_qr.png')
                        ->generate($request->qr_code);

        $codeNum = QrCodeModel::select('code_number', 'qr_unique_number')->get();
        return view('test.qr-code')->with(['qr_code'=> $code, 'code_number' => $codeNum]);
    }

    public function createQrCode(){
    	$qrCode = new QrCodeManager;
    	return $qrCode->generateQrCode(7);
    }
}
