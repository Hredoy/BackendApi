<?php
namespace App\Serializers;

use Illuminate\Http\UploadedFile as Uploadable;
use Illuminate\Support\Facades\Hash;

trait userLoginSerializer
{

	public function loginprocess($data)
	{
		foreach ($data as $key => $value) {

            switch ($value){
                case null:
                    break;

            }
		}

		return $data;
	}


}
