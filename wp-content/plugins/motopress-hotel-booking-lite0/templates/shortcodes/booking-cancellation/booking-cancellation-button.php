<?php

/**
 * Available parameters:
 *  string $cancellationLink
 * @since 3.9.9
 */

if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="mphb-booking-details-section cancel-booking">
    <a href="<?php echo esc_url( $cancellationLink ); ?>" class="button"><?php echo _e( 'Cancel Booking', 'motopress-hotel-booking' ); ?></a>
</div>
