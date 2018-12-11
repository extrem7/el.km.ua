<?php


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! empty( $breadcrumb ) ) {

	echo $wrap_before;

	foreach ( $breadcrumb as $key => $crumb ) {

		echo $before;

        if ( ! empty( $crumb[1] ) && sizeof( $breadcrumb ) !== $key + 1 ) {
            echo '<span itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem"><a href="' . esc_url( $crumb[1] ) . '" itemprop="item"><span itemprop="name">' . esc_html( $crumb[0] ) . '</span></a><meta itemprop="position" content="' . ($key + 1) . '" /></span>';
        } else {
            echo esc_html( $crumb[0] );
        }

		echo $after;

		if ( sizeof( $breadcrumb ) !== $key + 1 ) {
			echo $delimiter;
		}
	}

	echo $wrap_after;

}
