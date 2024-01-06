<?php

namespace Resources\JuanHR\Helpers\Includes;

use setasign\Fpdi\Fpdi;
class Letterspacing extends Fpdi
{
    protected $FontSpacingPt;      // current font spacing in points
    protected $FontSpacing;        // current font spacing in user units

    function SetFontSpacing( $size ) {
        if ( $this->FontSpacingPt == $size ) return;

        $this->FontSpacingPt = $size;
        $this->FontSpacing = $size / $this->k;

        if ( $this->page > 0 )
            $this->_out( sprintf( 'BT %.3f Tc ET', $size ) );
    }
}
?>
