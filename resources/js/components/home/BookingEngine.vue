<script setup>
import { computed, ref } from 'vue';

const checkIn = ref('');
const checkOut = ref('');

const bookingUrl = computed(() => {
    const baseUrl = 'https://letsbook.me/booking/satyagrahahotel';

    const params = new URLSearchParams();

    if (checkIn.value) {
        params.set('checkin', checkIn.value);
    }

    if (checkOut.value) {
        params.set('checkout', checkOut.value);
    }

    const query = params.toString();

    return query ? `${baseUrl}?${query}` : baseUrl;
});

const openBooking = () => {
    window.open(bookingUrl.value, '_blank', 'noopener,noreferrer');
};
</script>

<template>
    <section class="booking-engine-section relative z-30 px-4">
        <div class="booking-shell mx-auto max-w-6xl">
            <div class="booking-grid">
                <div class="booking-field">
                    <label for="checkIn">Check In</label>
                    <input id="checkIn" v-model="checkIn" type="date" />
                </div>

                <div class="booking-field">
                    <label for="checkOut">Check Out</label>
                    <input id="checkOut" v-model="checkOut" type="date" />
                </div>

                <button type="button" class="booking-btn" @click="openBooking">Book Now</button>
            </div>
        </div>
    </section>
</template>

<style scoped>
.booking-engine-section {
    margin-top: -36px;
    pointer-events: auto;
}

.booking-shell {
    position: relative;
    overflow: visible;
    border-radius: 28px;
    background: #2d2e24;
    box-shadow: 0 22px 55px rgba(45, 46, 36, 0.18);
}

.booking-grid {
    display: grid;
    grid-template-columns: minmax(220px, 1fr) minmax(220px, 1fr) 190px;
    align-items: end;
    gap: 28px;
    padding: 34px 48px;
    border-radius: 28px;
    background: #2d2e24;
}

.booking-field {
    min-width: 0;
}

.booking-field label {
    display: block;
    margin-bottom: 14px;
    color: rgba(255, 255, 255, 0.72);
    font-size: 13px;
    font-weight: 900;
    line-height: 1;
    letter-spacing: 0.28em;
    text-transform: uppercase;
}

.booking-field input {
    width: 100%;
    height: 58px;
    margin: 0;
    padding: 0 24px;
    border: 1px solid rgba(212, 175, 55, 0.65);
    border-radius: 999px;
    background: #ffffff;
    color: #2d2e24;
    font-size: 18px;
    font-weight: 800;
    line-height: 58px;
    letter-spacing: 0.04em;
    box-sizing: border-box;
    outline: none;
    box-shadow: none;
}

.booking-field input:focus {
    border-color: #d4af37;
    box-shadow: 0 0 0 4px rgba(212, 175, 55, 0.18);
}

.booking-btn {
    width: 100%;
    min-width: 0;
    height: 58px;
    margin: 0;
    padding: 0 26px;
    border: 1px solid #d4af37;
    border-radius: 999px;
    background: #d4af37;
    color: #2d2e24;
    font-size: 13px;
    font-weight: 900;
    line-height: 58px;
    letter-spacing: 0.24em;
    text-transform: uppercase;
    cursor: pointer;
    box-shadow: 0 14px 28px rgba(212, 175, 55, 0.24);
    transition:
        transform 0.22s ease,
        box-shadow 0.22s ease,
        background 0.22s ease,
        color 0.22s ease,
        border-color 0.22s ease;
}

.booking-btn:hover {
    border-color: #ffffff;
    background: #ffffff;
    color: #2d2e24;
    box-shadow: 0 16px 30px rgba(255, 255, 255, 0.14);
    transform: translateY(-1px);
}

@media only screen and (max-width: 900px) {
    .booking-engine-section {
        margin-top: -28px;
    }

    .booking-grid {
        grid-template-columns: 1fr 1fr;
        gap: 18px;
        padding: 26px;
    }

    .booking-btn {
        grid-column: 1 / -1;
    }
}

@media only screen and (max-width: 560px) {
    .booking-engine-section {
        margin-top: -20px;
        padding-left: 14px;
        padding-right: 14px;
    }

    .booking-shell {
        border-radius: 22px;
    }

    .booking-grid {
        display: block;
        padding: 18px;
        border-radius: 22px;
    }

    .booking-field {
        margin-bottom: 16px;
    }

    .booking-field label {
        margin-bottom: 10px;
        font-size: 11px;
        letter-spacing: 0.22em;
    }

    .booking-field input {
        height: 52px;
        font-size: 16px;
        line-height: 52px;
    }

    .booking-btn {
        height: 52px;
        margin-top: 2px;
        line-height: 52px;
    }
}
</style>
