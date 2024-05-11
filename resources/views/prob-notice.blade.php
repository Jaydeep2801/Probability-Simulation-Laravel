<?php

use App\Models\Prize;

$current_probability = floatval(Prize::sum('probability'));
?>

@if( $current_probability != 100 )
    <div class="alert alert-danger">
        Sum of all prizes must be 100%. Currently its {{ $current_probability }}%. You have yet to add {{ round( 100 - $current_probability, 2) }}% to the prize.    
    </div>
@endif