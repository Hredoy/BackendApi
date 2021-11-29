<?php
namespace App\Serializers;

use Illuminate\Http\UploadedFile as Uploadable;


trait Serializer
{

	public function process($data)
	{
		foreach ($data as $key => $value) {
            switch ($value){
                case null:
                    break;
                case is_object($value):
                    if(get_class($value)==Uploadable::class){
                        $data[$key]=$value->store('documents');
                    }
                    break;
            }
		}

		return $data;
	}


}
