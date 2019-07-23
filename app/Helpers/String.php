<?php

if ( ! function_exists( 'preg_explode' ) ) {
    function preg_explode( $string, string $delimiter = '|' )
    {
        $delimiter = $delimiter == '|' ? '\|' : $delimiter;
        return is_array( $string ) ? $string : preg_split( "/\s*{$delimiter}\s*/", $string );
    }
}

if ( ! function_exists( 'str_explode' ) ) {
    function str_explode( $string, $unique = true )
    {
        $array = is_array( $string ) ? $string : preg_split( '/\s*,\s*|\s*\|\s*|\s+/', $string );
        return $unique === false ? $array : @array_unique( $array, $unique );
    }
}

if ( ! function_exists( 'str_implode' ) ) {
    function str_implode( string $glue, $array )
    {
        return is_string( $array ) ? $array : implode( $glue, $array );
    }
}

if ( ! function_exists( 'str_purify' ) ) {
    function str_purify( $string, string $glue = ', ' )
    {
        return preg_replace( '/\s*,\s*|\s*\|\s*|\s+/', $glue, $string );
    }
}

if ( ! function_exists( 'encrypt_key' ) ) {
    function encrypt_key( $secret_key )
    {
        return hash( 'sha256', $secret_key ?: 'default key' );
    }
}

if ( ! function_exists( 'encrypt_iv' ) ) {
    function encrypt_iv( $secret_iv )
    {
        return substr( hash( 'md5', $secret_iv ?: 'default iv' ), 0, 16 );
    }
}

if ( ! function_exists( 'encrypt_str' ) ) {
    /**
     *
     * @param   string  $string
     * @param   string  $key
     * @return  string
     */
    function encrypt_str( $string, $key )
    {
        $method = "AES-256-CBC";
        $key    = encrypt_key( $key );
        $iv     = encrypt_iv( $key );
        return base64_encode( openssl_encrypt( $string, $method, $key, 0, $iv ) );
    }
}

if ( ! function_exists( 'decrypt_str' ) ) {
    function decrypt_str( $string, $key )
    {
        $method = "AES-256-CBC";
        $key    = encrypt_key( $key );
        $iv     = encrypt_iv( $key );

        return openssl_decrypt( base64_decode( $string ), $method, $key, 0, $iv );
    }
}

if ( ! function_exists( 'add_host' ) ) {
    function add_host( $url, $host )
    {
        return preg_match( '/^(http|https|ftp):\/\//i', $url ) ? $url : rtrim( $host, '/' ) . $url;
    }
}