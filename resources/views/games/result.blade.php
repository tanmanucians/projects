<?php $s=0 ;$i = 1; ?>
<h2>Result: </h2>

@foreach ($countTime_array as $timer)
    <li>Câu hỏi {{$i}}, Thời gian {{$timer}}</li>
<?php $i++; ?>
@endforeach