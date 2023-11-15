<div class="col-xxl-6 w-100">
  <div class="row">
    <div class="col-xxl-6 col-sm-6 mb-25">
      <!-- Card 1  -->
      <div class="ap-po-details ap-po-details--2 p-25 radius-xl d-flex justify-content-between">

        <div class="overview-content w-100">
            <div class=" ap-po-details-content d-flex flex-wrap justify-content-between">
                <div class="ap-po-details__titlebar">
                    <h1>{{ $total_users }}</h1>
                    <p>Total Users</p>
                </div>
                <div class="ap-po-details__icon-area">
                    <div class="svg-icon order-bg-opacity-info color-info">
                        <i class="uil la la-users"></i>
                    </div>
                </div>
            </div>
            <div class="ap-po-details-time">
                <span class="color-success"><i class="las la-arrow-up"></i>
                <strong>{{ $thisMonth }} New Users</strong></span>
                <small>Since last month</small>
            </div>
        </div>

      </div>
      <!-- Card 1 End  -->
    </div>
    <div class="col-xxl-6 col-sm-6 mb-25">
      <!-- Card 2 -->
      <div class="ap-po-details ap-po-details--2 p-25 radius-xl d-flex justify-content-between">
        <div class="overview-content w-100">
          <div class=" ap-po-details-content d-flex flex-wrap justify-content-between">
            <div class="ap-po-details__titlebar">
              <h1>{{ $today }}</h1>
              <p>Users Added Today</p>
            </div>
            <div class="ap-po-details__icon-area">
              <div class="svg-icon order-bg-opacity-info color-info">

                <i class="uil uil-user-plus"></i>
              </div>
            </div>
          </div>
          <div class="ap-po-details-time">
            <span class="color-success"><i class="la la-user-plus"></i>
              <strong>{{ $yesterday }} New Users</strong></span>
            <small>on yesterday</small>
          </div>
        </div>

      </div>
      <!-- Card 2 End  -->
    </div>
  </div>
</div>
