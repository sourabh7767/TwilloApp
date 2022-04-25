@extends('layouts.admin')

@section('title') Dashboard @endsection

@section('content')
  <!-- Dashboard Ecommerce Starts -->
  <section id="dashboard-ecommerce">
    <div class="row match-height">

      <!-- Statistics Card -->
      <div class="col-xl-12 col-md-12 col-12">
          <div class="card card-statistics">
              <div class="card-header">
                  <h4 class="card-title">Statistics</h4>
                  <div class="d-flex align-items-center">
                      <p class="card-text font-small-2 me-25 mb-0">Updated 1 month ago</p>
                  </div>
              </div>
              <div class="card-body statistics-body">
                  <div class="row">
                      <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-0">
                          <div class="d-flex flex-row">
                              <div class="avatar bg-light-primary me-2">
                                  <div class="avatar-content">
                                      <i data-feather="trending-up" class="avatar-icon"></i>
                                  </div>
                              </div>
                              <div class="my-auto">
                                  <h4 class="fw-bolder mb-0">230k</h4>
                                  <p class="card-text font-small-3 mb-0">Sales</p>
                              </div>
                          </div>
                      </div>
                      <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-0">
                          <div class="d-flex flex-row">
                              <div class="avatar bg-light-info me-2">
                                  <div class="avatar-content">
                                      <i data-feather="user" class="avatar-icon"></i>
                                  </div>
                              </div>
                              <div class="my-auto">
                                  <h4 class="fw-bolder mb-0">{{$users ? $users : 0}}</h4>
                                  <p class="card-text font-small-3 mb-0">Customers</p>
                              </div>
                          </div>
                      </div>
                      <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-sm-0">
                          <div class="d-flex flex-row">
                              <div class="avatar bg-light-danger me-2">
                                  <div class="avatar-content">
                                      <i data-feather="box" class="avatar-icon"></i>
                                  </div>
                              </div>
                              <div class="my-auto">
                                  <h4 class="fw-bolder mb-0">1.423k</h4>
                                  <p class="card-text font-small-3 mb-0">Products</p>
                              </div>
                          </div>
                      </div>
                      <div class="col-xl-3 col-sm-6 col-12">
                          <div class="d-flex flex-row">
                              <div class="avatar bg-light-success me-2">
                                  <div class="avatar-content">
                                      <i data-feather="dollar-sign" class="avatar-icon"></i>
                                  </div>
                              </div>
                              <div class="my-auto">
                                  <h4 class="fw-bolder mb-0">$9745</h4>
                                  <p class="card-text font-small-3 mb-0">Revenue</p>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <!--/ Statistics Card -->
    </div>
  </section>
    <!-- Dashboard Ecommerce ends -->

    
@endsection
