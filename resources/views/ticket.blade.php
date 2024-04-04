@extends('admin.layout.template')

@section('content')
     <!-- partial -->
     <div class="main-panel">
        
     <div class="card-body">
     <h4 class="card-title">Filtre</h4>

     </div>
     <form method="GET" action="{{ route('ticket') }}" class="mb-3">
    <div class="row">
      
        <div class="col-md-4">
            <div class="form-group">
                <label for="nom">Placing :</label>
                <input type="text" name="name" id="nom" class="form-control" value="" placeholder="Placing">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="email">Email :</label>
                <input type="text" name="email" id="email" class="form-control" value="" placeholder="Email">
            </div>
        </div>
        <!-- Ajoutez plus de champs de recherche selon vos besoins -->
        <div class="col-md-4">
            <div class="form-group mt-4">
                <button type="submit" class="btn btn-primary">Rechercher</button>
                <a href="{{ route('ticket') }}" class="btn btn-secondary">Réinitialiser</a>
            </div>
        </div>
    </div>
</form>

        <div class="content-wrapper">
            
          <div class="row">
            
            
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Liste des Tickets</h4>
                  <p class="card-description">
                  
                  </p>
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>
                            {{$nom}}
                          </th>
                          <th>
                          {{$email}}
                          </th>
                          <th>
                          {{$contact}}
                          </th>
                          <th>
                          {{$placing}}
                          </th>
                          <th>
                          {{$code}}
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        
                        @forelse ($tickets as $data)
                        <tr>
                          <td class="py-1">
                            {{$data->name}}
                          </td>
                          <td>
                            {{$data->email}}
                          </td>
                          <td>
                            <p>0141731900</p>
                          </td>
                          <td>
                            $ 77.99
                          </td>
                          <td>
                            {{$data->code}}
                          </td>
                        </tr>
                        @empty
                            <p>Aucun ticket enrégistré</p>
                        @endforelse
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            
            
           
          </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:../../partials/_footer.html -->
        @include('admin.layout.footer')
        <!-- partial -->
@endsection