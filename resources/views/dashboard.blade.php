@extends('admin.layout.template')

@section('content')
    <!-- partial -->
<div class="main-panel">
    <div class="content-wrapper">
      <div class="row">
        <div class="col-md-12 grid-margin">
          <div class="row">
            <div class="col-12 col-xl-8 mb-4 mb-xl-0">
              <h3 class="font-weight-bold"> Bienvenu !!!</h3>
              <!-- <h6 class="font-weight-normal mb-0">All systems are running smoothly! You have <span class="text-primary">3 unread alerts!</span></h6> -->
            </div>
            <!-- <div class="col-12 col-xl-4">
             <div class="justify-content-end d-flex">
              <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                <button class="btn btn-sm btn-light bg-white dropdown-toggle" type="button" id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                 <i class="mdi mdi-calendar"></i> Today (10 Jan 2021)
                </button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuDate2">
                  <a class="dropdown-item" href="#">January - March</a>
                  <a class="dropdown-item" href="#">March - June</a>
                  <a class="dropdown-item" href="#">June - August</a>
                  <a class="dropdown-item" href="#">August - November</a>
                </div>
              </div>
             </div>
            </div> -->
          </div>
        </div>
      </div>
      <div class="row">
        <!-- <div class="col-md-6 grid-margin stretch-card">
          <div class="card tale-bg">
            <div class="card-people mt-auto">
              <img src="{{asset('style/images/dashboard/people.svg')}}" alt="people">
              <canvas id="ticketChart" width="auto" height="auto"></canvas>
            </div>
          </div>
        </div> -->
        <div class="col-md-12 grid-margin transparent">
        <div class="row">
        <div class="col-md-4 mb-4 stretch-card transparent">
              <div class="card card-dark-blue">
              <div class="card-body">
                  
                  <p class="fs-30 mb-2"><i class="mdi mdi-ticket">{{$ticket}}</i></p>
                  <p class="mb-4">Total tickets</p>
                </div> 
              </div>
        </div>
        <div class="col-md-4 mb-4 stretch-card transparent">
              <div class="card card-light-blue">
              <div class="card-body">
                  
                  <p class="fs-30 mb-2"><i class="mdi mdi-ticket">{{$ticketCountStatus}}</i></p>
                  <p class="mb-4">Total tickets scannés</p>
                </div>
              </div>
        </div>
        <div class="col-md-4 mb-4 stretch-card transparent">
              <div class="card card-light-danger">
              <div class="card-body">
                  
                  <p class="fs-30 mb-2"><i class="mdi mdi-ticket">{{$ticketCountStatusI}}</i></p>
                  <p class="mb-4">Total tickets non scannés</p>
                </div>
              </div>
        </div>
        </div>
        <div class="row">
        
          @foreach ( $ticketCounts as $ticketCount )
          
            <div class="col-md-4 mb-4 stretch-card transparent">
              <div class="card card-tale {{ $ticketCount->color }}">
              <div class="card-body">
                  <p class="mb-4">{{ Strtoupper($ticketCount->placing) }}</p>
                  <p class="fs-30 mb-2">{{ $ticketCount->total }}</p>
                  <p ><a href="{{route('ticket')}}" style="color: white; height:20px">voir plus</a></p>
                </div>
              </div>
            </div>
            
            
          @endforeach 
            
          </div>
          <!-- <div class="row">
            <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent">
              <div class="card card-light-blue">
                <div class="card-body">
                  <p class="mb-4">public</p>
                  <p class="fs-30 mb-2">2023</p>
                  <p>2.00% (30 days)</p>
                </div>
              </div>
            </div>
            <div class="col-md-6 stretch-card transparent">
              <div class="card card-light-danger">
                <div class="card-body">
                  <p class="mb-4">vvip</p>
                  <p class="fs-30 mb-2">2034</p>
                  <p>0.22% (30 days)</p>
                </div>
              </div>
            </div>
          </div> -->
        </div>
      </div>
      
      <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
          <div class="card position-relative">
            <div class="card-body">
              <div id="detailedReports" class="carousel slide detailed-report-carousel position-static pt-2" data-ride="carousel">
                <div class="carousel-inner">
                 
                  <div class="carousel-item active">
                    <div class="row">
                      <div class="col-md-12 col-xl-3 d-flex flex-column justify-content-start">
                        <div class="ml-xl-4 mt-3">
                        <p class="card-title">Detail Evènement</p>
                          <h1 class="text-primary">{{$ticketCountStatus}}</h1>
                          <h3 class="font-weight-500 mb-xl-4 text-primary">Tickets Scannés</h3>
                          <!-- <p class="mb-2 mb-xl-0">The total number of sessions within the date range. It is the period time a user is actively engaged with your website, page or app, etc</p> -->
                        </div>  
                        </div>
                      <div class="col-md-12 col-xl-9">
                        <div class="row">
                          <div class="col-md-6 border-right">
                            <div class="table-responsive mb-3 mb-md-0 mt-3">
                              <table class="table table-borderless report-table">
                              @forelse ($ticketCounts as $ticketCount)
                                  <tr>
                                      <td class="text-muted">{{ Strtoupper($ticketCount->placing) }}</td>
                                      <td class="w-100 px-0">
                                          <div class="progress progress-md mx-4">
                                              @php
                                              // Calculer la largeur de la barre de progression en pourcentage
                                              $totalTickets = $ticket; // le nombre total de tickets.
                                              $progressPercentage = ($ticketCount->total / $totalTickets) * 100;
                                              // Déterminer la classe de couleur en fonction de la valeur
                                              $colorClass = $progressPercentage > 75 ? 'bg-success' : ($progressPercentage > 50 ? 'bg-info' : ($progressPercentage > 25 ? 'bg-warning' : 'bg-danger'));
                                              @endphp
                                              <div class="progress-bar {{ $colorClass }}" role="progressbar" style="width: {{ $progressPercentage }}%" aria-valuenow="{{ $progressPercentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                                              <!-- <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $progressPercentage }}%" aria-valuenow="{{ $progressPercentage }}" aria-valuemin="0" aria-valuemax="100"></div> -->
                                          </div>
                                      </td>
                                      <td><h5 class="font-weight-bold mb-0">{{ $ticketCount->total }}</h5></td>
                                  </tr>
                                  @empty
                                  <tr>
                                      <td class="text-muted">00</td>
                                      <td class="w-100 px-0">
                                          <div class="progress progress-md mx-4">
                                              <div class="progress-bar bg-primary" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                          </div>
                                      </td>
                                      <td><h5 class="font-weight-bold mb-0">Ticket scanné</h5></td>
                                  </tr>
                                  @endforelse

                              </table>
                            </div>
                          </div>
                          <div class="col-md-6 mt-3">
                          <canvas id="ticketChart" width="600" height="600"></canvas>
                            <!-- <div id="north-america-legend"></div> -->
                          </div>
                          
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- <div class="carousel-item">
                    <div class="row">
                      <div class="col-md-12 col-xl-3 d-flex flex-column justify-content-start">
                        <div class="ml-xl-4 mt-3">
                        <p class="card-title">Detailed Reports</p>
                          <h1 class="text-primary">$34040</h1>
                          <h3 class="font-weight-500 mb-xl-4 text-primary">North America</h3>
                          <p class="mb-2 mb-xl-0">The total number of sessions within the date range. It is the period time a user is actively engaged with your website, page or app, etc</p>
                        </div>  
                        </div>
                      <div class="col-md-12 col-xl-9">
                        <div class="row">
                          <div class="col-md-6 border-right">
                            <div class="table-responsive mb-3 mb-md-0 mt-3">
                              <table class="table table-borderless report-table">
                                <tr>
                                  <td class="text-muted">Illinois</td>
                                  <td class="w-100 px-0">
                                    <div class="progress progress-md mx-4">
                                      <div class="progress-bar bg-primary" role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                  </td>
                                  <td><h5 class="font-weight-bold mb-0">713</h5></td>
                                </tr>
                                <tr>
                                  <td class="text-muted">Washington</td>
                                  <td class="w-100 px-0">
                                    <div class="progress progress-md mx-4">
                                      <div class="progress-bar bg-warning" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                  </td>
                                  <td><h5 class="font-weight-bold mb-0">583</h5></td>
                                </tr>
                                <tr>
                                  <td class="text-muted">Mississippi</td>
                                  <td class="w-100 px-0">
                                    <div class="progress progress-md mx-4">
                                      <div class="progress-bar bg-danger" role="progressbar" style="width: 95%" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                  </td>
                                  <td><h5 class="font-weight-bold mb-0">924</h5></td>
                                </tr>
                                <tr>
                                  <td class="text-muted">California</td>
                                  <td class="w-100 px-0">
                                    <div class="progress progress-md mx-4">
                                      <div class="progress-bar bg-info" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                  </td>
                                  <td><h5 class="font-weight-bold mb-0">664</h5></td>
                                </tr>
                                <tr>
                                  <td class="text-muted">Maryland</td>
                                  <td class="w-100 px-0">
                                    <div class="progress progress-md mx-4">
                                      <div class="progress-bar bg-primary" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                  </td>
                                  <td><h5 class="font-weight-bold mb-0">560</h5></td>
                                </tr>
                                <tr>
                                  <td class="text-muted">Alaska</td>
                                  <td class="w-100 px-0">
                                    <div class="progress progress-md mx-4">
                                      <div class="progress-bar bg-danger" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                  </td>
                                  <td><h5 class="font-weight-bold mb-0">793</h5></td>
                                </tr>
                              </table>
                            </div>
                          </div>
                          <div class="col-md-6 mt-3">
                            <canvas id="south-america-chart"></canvas>
                            <div id="south-america-legend"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div> -->
                </div>
                <!-- <a class="carousel-control-prev" href="#detailedReports" role="button" data-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#detailedReports" role="button" data-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="sr-only">Next</span>
                </a> -->
              </div>
            </div>
          </div>
        </div>
      </div>
      
      
      
      
    </div>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
     var colors = ['rgba(255, 99, 132, 0.5)', 'rgba(54, 162, 235, 0.5)', 'rgba(255, 206, 86, 0.5)', 'rgba(75, 192, 192, 0.5)', 'rgba(153, 102, 255, 0.5)', 'rgba(255, 159, 64, 0.5)'];
     // Récupérer le contexte du canvas
    var ctx = document.getElementById('ticketChart').getContext('2d');

  // Créer le graphique
    var ticketChart = new Chart(ctx, {
    type: 'bar', //pie, line
    data: {
        labels: @json($labels),
        datasets: [{
            label: 'Nombre de Tickets par Catégorie',
            data: @json($totals),
            backgroundColor: colors,
            borderColor: colors.map(color => color.replace('0.5', '1')), // Assurez-vous que la bordure est plus foncée
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
   
</script>
    <!-- content-wrapper ends -->
    <!-- partial:partials/_footer.html -->
   @include('admin.layout.footer') 
    <!-- partial -->
@endsection