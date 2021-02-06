<?php 

namespace App\Http\Controllers\QRCode;

use App\Models\QRcode;

class QrCodeManager{

	//generate unique number for qr code and save to database
	public function generateQrCode($count){
		$codes = array();

		for ($i=1; $i <= $count; $i++) { 
			$uniqueID = strtoupper(md5(uniqid()));
			$data = array('qr_unique_number' => $uniqueID, 'code_number' => rand(1000, 9999), 'created_at' => now(), 'updated_at' => now());
			array_push($codes, $data);
		}

		$res = QRcode::insert($codes);
		return $res;
	}
}



?>