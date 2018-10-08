<div class="panel panel-default">
    <div class="panel-heading">Stats</div>
    <div class="panel-body">
      <div class="row">
          <div class="row">
              <div class="col-lg-12">
                  <div id="transfers-line-chart" style="height:220px"></div>
              </div>
          </div>
          <div class="col-lg-12">
              <div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover" id="statsTable">
                      <thead>
                          <tr>
                              <th>Date</th>
                              <th>Amount</th>
                              <th>Users</th>
                          </tr>
                      </thead>
                      <tbody>
                        @foreach ($stats as $stat)
                          <tr>
                              <td>{{ $stat->date }}</td>
                              <td>{{ $stat->amount }}</td>
                              <td>{{ $stat->users }}</td>
                          </tr>
                        @endforeach
                      </tbody>
                  </table>
              </div>
          </div>
      </div>
  </div>
</div>
@section('js')
@parent
<script type="text/javascript">
<?php
$min = 0;
$max = 0;
?>
var data = [];
@foreach ($stats as $stat)
data.push({
        period: '{{ $stat->date }}',
        shatoshis: {{ $stat->amount }}
    });
    <?php
        if(empty($min)){
            $min = $stat->amount;
            $max = $stat->amount;
        }else{
            if($min > $stat->amount){
                $min = $stat->amount;
            }
            if($max < $stat->amount){
                $max = $stat->amount;
            }
        }
    ?>
@endforeach

<?php
  $diff = ($max - $min)/2;
  $min = $min - $diff;
  $max = $max + $diff;
  if(($min<0)||($min==$max)){
      $min = 0;
  }
?>

Morris.Line({
    element: 'transfers-line-chart',
    data: data,
    xkey: 'period',
    ykeys: ['shatoshis'],
    labels: ['Shatoshis'],
    hideHover: 'auto',
    paddin: 10,
    ymin: {{$min}},
    ymax: {{$max}},
    yLabelFormat: function(y){
       return y/1000;
    }
});
</script>
@endsection
