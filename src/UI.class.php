<?php


namespace LanguageSwitcherExtension;


class UI
{

    public function __construct()
    {

    }

    public static function getResourceDirectory( $fileName, $subDirectory = 'css' )
    {
        // Allows for override of files
        $customPath = untrailingslashit( get_stylesheet_directory() ) . "/{$subDirectory}/{$fileName}";
        if( file_exists( $customPath ) ){
            return $customPath;
        }

        $filePath = plugin_dir_path( __FILE__ ) . "../resources/{$subDirectory}/{$fileName}";
        if( file_exists( $filePath ) ) {
            return apply_filters( 'lsex_resources_directory', $filePath );
        }
        return false;
    }

    public static function getResourceURL( $fileName, $subDirectory = 'css' )
    {
        if( UI::getResourceDirectory( $fileName, $subDirectory ) !== false ) {
            return plugin_dir_url( __FILE__ ) . "../resources/{$subDirectory}/{$fileName}";
        }

        return false;
    }
}