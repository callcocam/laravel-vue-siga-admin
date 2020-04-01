<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com
 * https://www.sigasmart.com.br
 */

namespace SIGA\Common;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

trait File {

	protected $use_user_id = true;

	protected $file = ['cover'];

	public function initFile(&$input) {

		if (is_array($this->file)):

			foreach ($this->file as $item):

				if (isset($input[$item])):

					if (is_null($input[$item])):

						unset($input[$item]);

					else:

						$input = $this->files($item, $input);

					endif;

				endif;

			endforeach;

		else:
			if (isset($input[$this->file])):

				if (is_null($input[$this->file])):

					unset($input[$this->file]);

				else:

					$input = $this->files($this->file, $input);

				endif;

			endif;

		endif;

		return $input;

	}

	protected function files($file, &$input) {

		if (is_string($input[$file])) {

			return $input;

		}
		/**
		 *@var $UploadedFile UploadedFile
		 */
		$UploadedFile = $input[$file];

		if ($UploadedFile->isValid()):

			return $this->upload_public($UploadedFile, $file, $input);

		endif;

		return $input;

	}

	public function upload_public(UploadedFile $UploadedFile, $file, &$input) {

		$date = Str::slug(date("Y|m"));

		$extension = $UploadedFile->clientExtension();

		if (array_search('type', $this->fillable)):
			$input['type'] = $UploadedFile->getMimeType();
		endif;
		if (array_search('width', $this->fillable)):
			 $input['width'] = $UploadedFile->getMimeType();
		endif;

		$original = explode('.', $UploadedFile->getClientOriginalName());

		$name = sprintf("%s-%s-%s.%s", rand(),time(),Str::slug(reset($original)), $extension);

		$path_upload = str_replace("|",DIRECTORY_SEPARATOR,sprintf("%s|%s|%s",  env('APP_PATH_UPLOAD', 'dist|uploads|files'),get_tenant_id(),$date));

		if ($this->use_user_id) {

			if(\Auth::id()){

				$path_upload = str_replace("|",DIRECTORY_SEPARATOR,sprintf("%s|%s|%s|%s",  env('APP_PATH_UPLOAD', 'dist|uploads|files'),get_tenant_id(),\Auth::id(),$date));

			}

		}

		$path_dest = public_path($path_upload);

		$file_name = str_replace([DIRECTORY_SEPARATOR,'//'],["/",'/'],sprintf("/%s/%s", $path_upload, $name));

		$UploadedFile->move($path_dest, $name);

		if (is_file(sprintf("%s/%s", $path_dest, $name))):

			$input[$file] = $file_name;

		endif;
		// $input['public'] = public_path();
		// $input['cover_new'] = $file_name;
		// $input['path_upload'] = $path_upload;
		// $input['user'] = \Auth::id();
		// $input['path'] = $path_dest;
		return $input;
	}

	public function saveUpload($data){


	}
}
