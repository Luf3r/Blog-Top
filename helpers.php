<?php

function formatDateTime($date) {
    return date('d/m/Y H:i', strtotime($date));
}