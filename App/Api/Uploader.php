<?php
namespace App\Api;

use stdClass;
use App\AppConfig;

class Uploader
{
    private $filename;    
    private $dest_folder;
    private $save_folder;

    public function __construct($dest_folder='kits', $save_folder='')
    {
        $this->filename = '';        
        $this->dest_folder = $dest_folder;
        $this->save_folder = $save_folder;
        if (!file_exists($this->dest_folder)) {
            mkdir($this->dest_folder, 0777, true);
        }
    }

    function uploadKit() 
    {
        if(isset($_POST['submit'])){
            $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
            $isZipExtension = ( $extension == "zip" ? true : false );
            $zipTypes = array('application/zip', 'application/x-zip-compressed', 
            'multipart/x-zip', 'application/x-compressed');
            $isZipFile = in_array( $_FILES['file']["type"], $zipTypes );            
    
            if( $isZipFile && $isZipExtension) {
                $src_path = $_FILES['file']['tmp_name'];
                $dst_path = __DIR__.'/'.$this->sanitizeFilename($_FILES['file']['name']);
                move_uploaded_file($src_path, $dst_path);
                $this->filename = realpath($dst_path);
            }
        }        
    }

    public static function clean($dest_folder)
    {
        //Get a list of all of the file names in the folder.
        $files = glob($dest_folder . '/*');
        print_r($files);
        foreach($files as $file) {
            if (is_file($file)) {
                unlink($file);                
            } else {                
                Uploader::clean($file);
            }
        }
        rmdir($dest_folder);
        echo 'Should have been cleaned';
    }

    static function sanitizeFilename($filename)
    {
        return preg_replace( '/[\r\n\t -]+/', '-', $filename );
    }

    function prepareKit()
    {
        echo 'Prepare kit';
        $zip = new \ZipArchive;        
        $res = $zip->open($this->filename);
        $save_folder = strtolower($this->dest_folder).$this->save_folder.'-'.time();
        if (!file_exists($save_folder)) {
            mkdir($save_folder, 0777, true);
        }
        if ($res === TRUE) {
            // extract it to the path we determined above
            $zip->extractTo($save_folder);
            $zip->close();
            unlink($this->filename);
            echo "WOOT! $this->filename extracted to $this->dest_folder";
            $result = new stdClass;
            $result->name = basename($this->save_folder);
            $result->location = basename($this->dest_folder).strtolower($this->save_folder).'-'.time().'/';
            return $result;
        } else {
            echo "Doh! I couldn't open $this->filename";
        }
    }

    static function backHome()
    {
        header("Location: /");
    }
}

// $uploader = new Uploader;
// $uploader->uploadKit();
// $uploader->prepareKit();
// Uploader::clean('kits');
?>