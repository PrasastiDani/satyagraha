<script setup>
import { onBeforeUnmount, onMounted } from 'vue';

const loadCss = (href, id) => {
    if (document.getElementById(id)) return;

    const link = document.createElement('link');
    link.id = id;
    link.rel = 'stylesheet';
    link.type = 'text/css';
    link.href = href;
    document.head.appendChild(link);
};

const loadScript = (src, id) => {
    return new Promise((resolve, reject) => {
        if (document.getElementById(id)) {
            resolve();
            return;
        }

        const script = document.createElement('script');
        script.id = id;
        script.src = src;
        script.type = 'text/javascript';
        script.onload = resolve;
        script.onerror = reject;

        document.body.appendChild(script);
    });
};

const initBookingBox = () => {
    if (!window.jQuery || !window.jQuery.fn || !window.jQuery.fn.bb_resBookingBox) {
        console.warn('Booking engine belum siap.');
        return;
    }

    window.jQuery('#bb_resBookingBox').html('&nbsp;');

    window.jQuery('#bb_resBookingBox').bb_resBookingBox({
        btnContainer: 'bb_resBookingBox',
        headerColor: '#2d2e24',
        bodyColor: '#2d2e24',
        showborder: false,
        BorderColor: '#2d2e24',
        BorderWidth: 0,
        BorderType: 'solid',
        FontFamily: 'Arial, Helvetica, sans-serif',
        BodyLanguage: 'en',
        FontSize: '12',
        TextColor: '#FFFFFF',
        InputBorderColor: '#d4af37',
        InputbackColor: '#fff',
        InputTextColor: '#2d2e24',
        ButnBackColor: '#d4af37',
        ButnBorderColor: '#d4af37',
        ButnTextColor: '#2d2e24',
        HeaderTextColor: '#FFFFFF',
        HeaderFontSize: '15',
        ShowHeader: '0',
        boxwidth: '100',
        boxwidthtype: 'TYPE_PER',
        ShowInlineCSS: '1',
        type: 'htype',
        acr: false,
        ShowChild: false,
        rooms: false,
        promotion: false,
        defaultadult: 2,
        defaultchild: 0,
        defaultroom: 1,
        ShowNights: false,
        Nonights: 15,
        HTextCaption: 'Reservation',
        BtnTextCaption: 'Book Now',
        LblPromoCaption: 'Promotion',
        LblChkOutCaption: 'Check Out',
        Calinit: true,
        CalShowOn: 'both',
        CalDefaultDt: '+0w',
        CalChangeMonth: true,
        CalMinDate: '0',
        CalMaxDate: '',
        CalDtFormat: 'dd-mm-yy',
        CalCutoffDays: '1',
        CalImage: '1px -24px',
        CalBackColor: '#fcfbf7',
        CalHeaderColor: '#2d2e24',
        CalCellActiveColor: '#d4af37',
        CalCellInActiveColor: '#f1ead8',
        LblArrivalCaption: 'Check In',
        LblNightsCaption: 'Nights',
        LblAdultsCaption: 'Adult',
        LblChildsCaption: 'Child',
        LblRoomsCaption: 'Rooms',
        LblPerRoomCaption: 'Per Room',
        HotelId: 'satyagrahahotel',
    });
};

onMounted(async () => {
    loadCss('https://live.ipms247.com/themes/reservation/css/bookingbtn/resui_datepicker.css', 'ipms-datepicker-css');
    loadCss('https://live.ipms247.com/themes/reservation/css/bookingbtn/resui_bookingbox.css', 'ipms-bookingbox-css');

    try {
        if (!window.jQuery) {
            await loadScript('https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js', 'jquery-3-4-1');
        }

        await loadScript('https://live.ipms247.com/themes/reservation/js/bookingbtn/jquery-ui.js', 'ipms-jquery-ui');
        await loadScript('https://live.ipms247.com/themes/reservation/js/bookingbtn/common.js', 'ipms-common-js');
        await loadScript('https://live.ipms247.com/themes/reservation/js/bookingbtn/resui_resbookingbox.js', 'ipms-bookingbox-js');

        initBookingBox();
    } catch (error) {
        console.error('Gagal memuat booking engine:', error);
    }
});

onBeforeUnmount(() => {
    const box = document.getElementById('bb_resBookingBox');

    if (box) {
        box.innerHTML = '&nbsp;';
    }
});
</script>

<template>
    <section class="booking-engine-section relative z-30 px-4">
        <div class="booking-shell mx-auto max-w-6xl">
            <form
                class="booking-form"
                action="https://live.ipms247.com/booking/book-rooms-satyagrahahotel"
                method="post"
                name="_resBBBox"
                target="_blank"
            >
                <div id="bb_resBookingBox" class="bb_resbox">&nbsp;</div>
            </form>
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

.booking-form {
    margin: 0;
}

/* wrapper utama dari plugin */
:deep(.bb_resbox) {
    width: 100% !important;
    display: grid !important;
    grid-template-columns: minmax(220px, 1fr) minmax(220px, 1fr) 190px !important;
    align-items: end !important;
    gap: 28px !important;
    padding: 34px 48px !important;
    border-radius: 28px !important;
    background: #2d2e24 !important;
    text-align: left !important;
    box-sizing: border-box !important;
}

/* field wrapper bawaan plugin */
:deep(.bb_resbox p) {
    width: 100% !important;
    min-width: 0 !important;
    margin: 0 !important;
    padding: 0 !important;
    display: block !important;
    box-sizing: border-box !important;
}

/* label */
:deep(.bb_resbox label) {
    display: block !important;
    height: auto !important;
    margin: 0 0 14px !important;
    padding: 0 !important;
    color: rgba(255, 255, 255, 0.72) !important;
    font-size: 13px !important;
    font-weight: 900 !important;
    line-height: 1 !important;
    letter-spacing: 0.28em !important;
    text-transform: uppercase !important;
}

/* input */
:deep(.bb_resbox input[type='text']),
:deep(.bb_resbox select) {
    width: 100% !important;
    min-width: 0 !important;
    height: 58px !important;
    margin: 0 !important;
    padding: 0 24px !important;
    border: 1px solid rgba(212, 175, 55, 0.65) !important;
    border-radius: 999px !important;
    background: #ffffff !important;
    color: #2d2e24 !important;
    font-size: 18px !important;
    font-weight: 800 !important;
    line-height: 58px !important;
    letter-spacing: 0.04em !important;
    box-sizing: border-box !important;
    outline: none !important;
    box-shadow: none !important;
}

:deep(.bb_resbox input[type='text']:focus),
:deep(.bb_resbox select:focus) {
    border-color: #d4af37 !important;
    box-shadow: 0 0 0 4px rgba(212, 175, 55, 0.18) !important;
}

/* icon datepicker */
:deep(.bb_resbox button.ui-datepicker-trigger) {
    width: 34px !important;
    height: 34px !important;
    margin-left: -46px !important;
    margin-top: 12px !important;
    padding: 0 !important;
    border: none !important;
    background: transparent !important;
    position: relative !important;
    z-index: 2 !important;
    vertical-align: top !important;
}

/* tombol Book Now */
:deep(input[type='button']#bb_resBtn),
:deep(input#bb_resBtn) {
    width: 100% !important;
    min-width: 0 !important;
    height: 58px !important;
    margin: 0 !important;
    padding: 0 26px !important;
    border: 1px solid #d4af37 !important;
    border-radius: 999px !important;
    background: #d4af37 !important;
    color: #2d2e24 !important;
    -webkit-appearance: none;
    font-size: 13px !important;
    font-weight: 900 !important;
    line-height: 58px !important;
    letter-spacing: 0.24em !important;
    text-transform: uppercase !important;
    cursor: pointer !important;
    box-shadow: 0 14px 28px rgba(212, 175, 55, 0.24) !important;
    transition:
        transform 0.22s ease,
        box-shadow 0.22s ease,
        background 0.22s ease,
        color 0.22s ease,
        border-color 0.22s ease;
}

:deep(#bb_resBtn:hover) {
    border-color: #ffffff !important;
    background: #ffffff !important;
    color: #2d2e24 !important;
    box-shadow: 0 16px 30px rgba(255, 255, 255, 0.14) !important;
    transform: translateY(-1px);
}

/* datepicker popup */
:deep(.ui-datepicker) {
    z-index: 9999 !important;
    border: 1px solid rgba(212, 175, 55, 0.35) !important;
    border-radius: 16px !important;
    overflow: hidden !important;
    box-shadow: 0 18px 48px rgba(45, 46, 36, 0.22) !important;
    font-family: Arial, Helvetica, sans-serif !important;
}

:deep(.ui-datepicker-header) {
    border: none !important;
    background: #2d2e24 !important;
    color: #ffffff !important;
}

:deep(.ui-datepicker .ui-datepicker-title select) {
    display: inline-block !important;
    max-width: 76px !important;
    min-width: 76px !important;
    border-radius: 8px !important;
}

:deep(.ui-datepicker td a) {
    border-radius: 9px !important;
    text-align: center !important;
}

:deep(.ui-datepicker .ui-state-active) {
    border-color: #d4af37 !important;
    background: #d4af37 !important;
    color: #2d2e24 !important;
}

/* tablet */
@media only screen and (max-width: 900px) {
    .booking-engine-section {
        margin-top: -28px;
    }

    :deep(.bb_resbox) {
        grid-template-columns: 1fr 1fr !important;
        gap: 18px !important;
        padding: 26px !important;
    }

    :deep(input[type='button']#bb_resBtn),
    :deep(input#bb_resBtn) {
        grid-column: 1 / -1 !important;
        width: 100% !important;
    }
}

/* mobile */
@media only screen and (max-width: 560px) {
    .booking-engine-section {
        margin-top: -20px;
        padding-left: 14px;
        padding-right: 14px;
    }

    .booking-shell {
        border-radius: 22px;
    }

    :deep(.bb_resbox) {
        display: block !important;
        padding: 18px !important;
        border-radius: 22px !important;
    }

    :deep(.bb_resbox p) {
        width: 100% !important;
        margin-bottom: 16px !important;
    }

    :deep(.bb_resbox label) {
        margin-bottom: 10px !important;
        font-size: 11px !important;
        letter-spacing: 0.22em !important;
    }

    :deep(.bb_resbox input[type='text']),
    :deep(.bb_resbox select) {
        width: 100% !important;
        height: 52px !important;
        font-size: 16px !important;
        line-height: 52px !important;
    }

    :deep(input[type='button']#bb_resBtn),
    :deep(input#bb_resBtn) {
        width: 100% !important;
        height: 52px !important;
        margin-top: 2px !important;
        line-height: 52px !important;
    }
}
</style>
