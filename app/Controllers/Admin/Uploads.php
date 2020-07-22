<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\Config\Services;

/**
 * Class for handling file uploads.
 */
class Uploads extends BaseController {
	/**
	 * Sets up the helpers.
	 */
	public function __construct() {
		helper('form');
	}

	/**
	 * Displays a list of uploads.
	 */
	public function index() {
		return view('admin/uploads', ['images' => $this->getImagesList(), 'files' => $this->getFilesList()]);
	}

	public function handleUpload(){
		$files = $this->request->getFileMultiple('userfile');
		/**
		 * @var \CodeIgniter\HTTP\Files\UploadedFile $file
		 */
		foreach($files as $file){
			// Check whether the file is an image.
			if ( strpos($file->getMimeType(), 'image') !== false ){
				// Move the file to the image directory
				$file->move('./fotos/');
				
				// Generate a thumbnail
				$this->generateThumbnail($file->getTempName(), $file->getName());
				
				// Profit
				return redirect()->back()->with('success', 'Gelukt!');
			}

			// Move the file to the files directory
			$file->move('./files/');

			// Profit
			return redirect()->back()->with('success', 'Gelukt!');
		}
	}

	/**
	 * Function to delete a file
	 *
	 * @param string $type Type of file we are deleting.
	 * @param string $path Path to the file.
	 */
	public function delete(string $type, string $path) {
		if ($type === "files") {
			$url = './files/';
		} elseif ($type === "fotos") {
			$url = './fotos/';
		}
		$path = preg_replace('/[^A-z0-9. ()\-_]/', '', rawurldecode($path));
		$file = $url . $path;
		if (is_file($file)) {
			unlink($file);
			return redirect()->back()->with('success', 'Het bestand is verwijderd!');
		}

		return redirect()->back()->with('error', 'Er is iets mis gegaan');
	}

	/**
	 * Generate a thumbnail for an image.
	 */
	private function generateThumbnail( string $path, $name ){
		\Config\Services::image('imagick')
        	->withFile($path . $name)
        	->fit(100, 100, 'center')
			->save('./fotos/thumb/' . $name);
		return true;
	}

	/**
	 * Generates a list of files.
	 */
	private function getFilesList() {
		$files = [];
		foreach (glob('./files/*.*') as $file) {
			if ($file === './files/index.php') {
				continue;
			}
			$document = new \stdClass();
			$document->naam = basename($file);
			$document->url = '/files/' . basename($file);
			$document->deleteUrl = '/admin/uploads/delete/files/' . basename($file);
			array_push($files, $document);
		}

		return $files;
	}

	/**
	 * Generates a list of images.
	 */
	private function getImagesList() {
		$files = [];
		foreach (glob('./fotos/*.*') as $file) {
			if ($file === './fotos/index.php') {
				continue;
			}
			$image = new \stdClass();
			$naam = explode(' ', basename($file));
			if (sizeof($naam) > 2) {
				unset($naam[0]);
				unset($naam[1]);
			}
			$naam = implode(" ", $naam);
			$image->naam = $naam;
			$image->url = '/fotos/' . basename($file);
			$image->thumb = '/fotos/thumb/' . basename($file);
			$image->deleteUrl = '/admin/uploads/delete/fotos/' . basename($file);
			array_push($files, $image);
		}

		return $files;
	}
}
