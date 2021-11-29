<?php
namespace App\Serializers;

use Illuminate\Http\UploadedFile as Uploadable;
use Illuminate\Support\Facades\Hash;

trait userRegisterSerializer
{

	public function process($data)
	{
		foreach ($data as $key => $value) {

           if($key == "password"){

                $data[$key]=bcrypt($value);
            }
		}

		return $data;
	}


}
