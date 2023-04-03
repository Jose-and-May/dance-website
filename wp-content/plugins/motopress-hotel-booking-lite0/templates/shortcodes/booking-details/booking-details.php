<?php
/**
 * Available variables:
 *  object \MPHB\Entities\Booking $booking
 *  string $checkInDateFormatted
 *  string $checkOutDateFormatted
 *  string $accommodations
 *
 * @since 3.9.9
 */

if (!defined('ABSPATH')) {
    exit;
}
?>

<div class="mphb-booking-details-section booking">
    <h3 class="mphb-booking-details-title"><?php _e('Booking Details', 'motopress-hotel-booking'); ?></h3>
    <ul class="mphb-booking-details">
        <li class="booking-number">
            <span class="label"><?php _e('Booking:', 'motopress-hotel-booking'); ?></span>
            <span class="value"><?php echo esc_html( $booking->getId() ); ?></span>
        </li>
        <li class="booking-check-in">
            <span class="label"><?php _e('Check-in:', 'motopress-hotel-booking'); ?></span>
            <span class="value"><?php echo esc_html( $checkInDateFormatted ); ?></span>
        </li>
        <li class="booking-check-out">
            <span class="label"><?php _e('Check-out:', 'motopress-hotel-booking'); ?></span>
            <span class="value"><?php echo esc_html( $checkOutDateFormatted ); ?></span>
        </li>
        <li class="booking-price">
            <span class="label"><?php _e('Total:', 'motopress-hotel-booking'); ?></span>
            <span class="value"><?php echo mphb_format_price($booking->getTotalPrice()); ?></span>
        </li>
        <li class="booking-status">
            <span class="label"><?php _e('Status:', 'motopress-hotel-booking'); ?></span>
            <span class="value"><?php echo esc_html( mphb_get_status_label($booking->getStatus()) ); ?></span>
        </li>
    </ul>
    <div class="accommodations">
        <span class="accommodations-title"><?php _e('Details:', 'motopress-hotel-booking'); ?></span>
        <span class="accommodations-list"><?php echo $accommodations; ?></span>
    </div>
</div>
