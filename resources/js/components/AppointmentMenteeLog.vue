<template>
  <div>
    <section class="appointment-log">
      <div class="container">
          <div class="row">
              <div class="col-md-12">
                  <h1 class="text-secondary fw-bold text-center mb-5">
                      {{ $t("appointment_log.main_title") }}
                    </h1>
              </div>
          </div>

           <!-- tabs -->
        <ul
            class="nav nav-pills mentor-profile-tabs mt-4"
            id="pills-tab"
            role="tablist"
          >


            <li
              class="nav-item mb-md-0 mb-4 w-25"
              role="presentation"
            >
              <button
                class="nav-link active w-100 p-md-0"
                id="pills-pending-tab"
                data-bs-toggle="pill"
                data-bs-target="#pills-pending"
                type="button"
                role="tab"
                aria-controls="pills-pending"
                aria-selected="true"
                @click="fetchPendingAppointments"

              >
                <div class="border-top-nav position-relative mb-3">
                  <i class="fas fa-circle position-absolute"></i>
                </div>
                <div class="text-dark mentor-head">
                     <!-- Pending Appointments  -->
                    {{ $t("appointment_log.label_1") }}

                     </div>
              </button>
            </li>
            <li
              class="nav-item mb-md-0 mb-4 w-25"
              role="presentation"
            >
              <button
                class="nav-link w-100 p-md-0"
                id="pills-acceptapp-tab"
                data-bs-toggle="pill"
                data-bs-target="#pills-acceptapp"
                type="button"
                role="tab"
                aria-controls="pills-acceptapp"
                aria-selected="false"
                @click="fetchAcceptedAppointments"
              >
                <div class="border-top-nav position-relative mb-3">
                  <i class="fas fa-circle position-absolute"></i>
                </div>
                <div class="text-dark mentor-head">
                    {{ $t("appointment_log.label_2") }}

                </div>
              </button>
            </li>
            <li
              class="nav-item mb-md-0 mb-4 w-25"
              role="presentation"
            >
              <button
                class="nav-link w-100 p-md-0"
                id="pills-cancelapp-tab"
                data-bs-toggle="pill"
                data-bs-target="#pills-cancelapp"
                type="button"
                role="tab"
                aria-controls="pills-cancelapp"
                aria-selected="false"
                @click="fetchCancelledAppointments"
              >
                <div class="border-top-nav position-relative mb-3">
                  <i class="fas fa-circle position-absolute"></i>
                </div>
                <div class="text-dark mentor-head">
                    {{ $t("appointment_log.label_3") }}

                </div>
              </button>
            </li>
            <li
              class="nav-item mb-md-0 mb-4 w-25"
              role="presentation"
            >
              <button
                class="nav-link w-100 p-md-0"
                id="pills-compapp-tab"
                data-bs-toggle="pill"
                data-bs-target="#pills-compapp"
                type="button"
                role="tab"
                aria-controls="pills-compapp"
                aria-selected="false"
                @click="fetchCompletedAppointments"
              >
                <div class="border-top-nav position-relative mb-3">
                  <i class="fas fa-circle position-absolute"></i>
                </div>
                <div class="text-dark mentor-head">
                    {{ $t("appointment_log.label_4") }}

                </div>
              </button>
            </li>
          </ul>
          <div class="tab-content" id="pills-tabContent">

               <!-- pending appointmnets -->
              <div
              class="tab-pane fade show active"
              id="pills-pending"
              role="tabpanel"
              aria-labelledby="pills-pending-tab"
            >
   <div class="row">
          <div class="col-md-12">
            <div class="bg-white px-2">
              <div class="row">
                <div class="col-md-4">

                </div>
<div class="col-md-4">

                </div>
                <div class="col-lg-4">
                  <div class="p-3 py-2">
                    <div class="d-flex align-items-center h-100">
                      <div class="w-25">
                        <label for="filter" class="pe-2 text-primary fw-bold"
                          >Search:</label
                        >
                      </div>
                      <div class="w-100">
                        <!-- <form action=""> -->
                          <input
                            type="text"
                            name=""
                            id=""
                            class="form-control border"
                            :placeholder="
                              $t(
                                'appointment_log.tab.all_appointments.search.label'
                              )
                            "
                            v-model="search_pending"
                            @change="searchPendingAppointments"
                          />
                          <div class="search-icon position-relative">
                            <i
                              class="fa-solid fa-magnifying-glass text-primary"
                            ></i>
                          </div>
                        <!-- </form> -->
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="bg-white mt-4">
              <div class="table-responsive">
                <table
                  class="table table-striped table-borderless align-middle mb-0"
                >
                  <thead class="align-middle">
                    <!-- head -->
                    <tr class="bg-primary text-white fw-bold">
                      <td class="p-3">
                        {{ $t("appointment_log.tab.pending.column.question") }}
                      </td>
                      <td class="p-3">
                        {{ $t("appointment_log.tab.pending.column.name") }}
                      </td>
                      <td class="p-3">
                        {{ $t("appointment_log.tab.pending.column.date") }}
                      </td>
                      <td class="p-3">
                        {{ $t("appointment_log.tab.pending.column.time") }}
                      </td>
                      <td class="p-3">
                        {{ $t("appointment_log.tab.pending.column.type") }}
                      </td>
                      <td class="p-3">
                        {{ $t("appointment_log.tab.pending.column.amount") }}
                      </td>
                      <td class="p-3">
                        {{ $t("appointment_log.tab.pending.column.p_Status") }}
                      </td>
                      <td class="p-3">
                        {{ $t("appointment_log.tab.pending.column.status") }}
                      </td>
                      <td class="p-3">
                        {{ $t("appointment_log.tab.pending.column.action") }}
                      </td>
                    </tr>
                    <!-- head end -->
                  </thead>
                  <tbody class="text-dark">
                    <tr v-if="loading">
                      <td align="center" colspan="9"><img src="/assets/images/loader.gif" height="100px" alt=""></td>
                    </tr>
                    <tr
                      v-else
                      v-for="appointment in allPendingAppointmentsFilter"
                      :key="appointment.id"
                    >
                      <td
                        v-if="appointment.questions != null"
                        class="mb-0"

                      >
                         <div class="wrap-ques ps-2
                        ">
                          {{ appointment.questions }}</div>
                      </td>
                      <td v-else>N/A</td>
                      <td
                        v-if="appointment.mentor.first_name && appointment.mentor.last_name"
                      >
                        {{ appointment.mentor.first_name }}
                        {{ appointment.mentor.last_name }}
                      </td>
                      <td v-else>Mentor</td>
                      <!-- <td>{{ appointment.id }}</td> -->
                      <td>{{ appointment.date }}</td>
                      <td>{{ appointment.time }}</td>
                      <td>{{ appointment.appointment_type_string }}</td>
                      <td>
                        <span class="text-success fw-400"
                          >{{currency_symbol}} {{ appointment.payment }}</span
                        >
                      </td>
                      <td v-if="appointment.is_paid == 1">
                        <span class="text-primary me-2"
                          ><i class="fas fa-check"></i
                        ></span>
                        {{ $t("appointment_log.tab.pending.column.paid_text") }}
                      </td>
                      <td v-if="appointment.is_paid == 0">
                        <span class="text-danger me-2"
                          ><i class="fas fa-times"></i
                        ></span>
                        {{
                          $t("appointment_log.tab.pending.column.unpaid_text")
                        }}
                      </td>
                      <td v-if="appointment.appointment_status == 0">
                        {{
                          $t(
                            "appointment_log.tab.pending.column.appointment_status.pending"
                          )
                        }}
                      </td>
                      <td v-if="appointment.appointment_status == 1">
                        {{
                          $t(
                            "appointment_log.tab.pending.column.appointment_status.accepted"
                          )
                        }}
                      </td>
                      <td v-if="appointment.appointment_status == 2">
                        {{
                          $t(
                            "appointment_log.tab.pending.column.appointment_status.completed"
                          )
                        }}
                      </td>
                      <td v-if="appointment.appointment_status == 3">
                        {{
                          $t(
                            "appointment_log.tab.pending.column.appointment_status.cancel"
                          )
                        }}
                      </td>
                      <td>
                        <a
                          :href="`${
                            url + '/mentee/appointment-log-detail/' + appointment.id
                          }`"
                          class="btn btn-primary mb-md-0 mb-2 btn-sm"
                          >{{
                            $t(
                              "appointment_log.tab.pending.button.view_details"
                            )
                          }}</a>
                      </td>
                    </tr>
                    <tr v-if="allPendingAppointmentsFilter.length == 0 && !loading">
                        <td colspan="9" class="text-center">
                            No record found
                        </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div
              class="
                btn-load-more
                d-flex
                justify-content-center
                align-items-center
              "
            >
              <v-page
                :total-row="allPendingAppointments.length"
                align="left"
                v-model="current"
                @page-change="allPendingAppointmentsChange"
                :page-size-menu="[10, 20, 30]"
                v-if="!loading && allPendingAppointments.length>0"
              ></v-page>
            </div>
          </div>
        </div>
              </div>

              <!-- accepted appointmnets -->

              <div
              class="tab-pane fade"
              id="pills-acceptapp"
              role="tabpanel"
              aria-labelledby="pills-acceptapp-tab"
            >
        <div class="row">
          <div class="col-md-12">
            <div class="bg-white px-2">
              <div class="row">
                <div class="col-md-4">

                </div>
<div class="col-md-4">

                </div>
                <div class="col-lg-4">
                  <div class="p-3 py-2">
                    <div class="d-flex align-items-center h-100">
                      <div class="w-25">
                        <label for="filter" class="pe-2 text-primary fw-bold"
                          >Search:</label
                        >
                      </div>
                      <div class="w-100">
                        <!-- <form action=""> -->
                          <input
                            type="text"
                            name=""
                            id=""
                            class="form-control border"
                            :placeholder="
                              $t(
                                'appointment_log.tab.all_appointments.search.label'
                              )
                            "
                            v-model="search_accepted"
                            @change="searchAcceptedAppointments"
                          />
                          <div class="search-icon position-relative">
                            <i
                              class="fa-solid fa-magnifying-glass text-primary"
                            ></i>
                          </div>
                        <!-- </form> -->
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="bg-white mt-4">
              <div class="table-responsive">
                <table
                  class="table table-striped table-borderless align-middle mb-0"
                >
                  <thead class="align-middle">
                    <!-- head -->
                    <tr class="bg-primary text-white fw-bold">
                      <td class="p-3">
                        {{ $t("appointment_log.tab.pending.column.question") }}
                      </td>
                      <td class="p-3">
                        {{ $t("appointment_log.tab.pending.column.name") }}
                      </td>
                      <td class="p-3">
                        {{ $t("appointment_log.tab.pending.column.date") }}
                      </td>
                      <td class="p-3">
                        {{ $t("appointment_log.tab.pending.column.time") }}
                      </td>
                      <td class="p-3">
                        {{ $t("appointment_log.tab.pending.column.type") }}
                      </td>
                      <td class="p-3">
                        {{ $t("appointment_log.tab.pending.column.amount") }}
                      </td>
                      <td class="p-3">
                        {{ $t("appointment_log.tab.pending.column.p_Status") }}
                      </td>
                      <td class="p-3">
                        {{ $t("appointment_log.tab.pending.column.status") }}
                      </td>
                      <td class="p-3">
                        {{ $t("appointment_log.tab.pending.column.action") }}
                      </td>
                    </tr>
                    <!-- head end -->
                  </thead>
                  <tbody class="text-dark">
                    <tr v-if="loading">
                      <td align="center" colspan="9"><img src="/assets/images/loader.gif" height="100px" alt=""></td>
                    </tr>
                    <tr
                      v-else
                      v-for="appointment in allAcceptedAppointmentsFilter"
                      :key="appointment.id"
                    >
                      <td
                        v-if="appointment.questions != null"
                        class="mb-0"

                      >
                         <div class="wrap-ques ps-2
                        ">
                          {{ appointment.questions }}</div>
                      </td>
                      <td v-else>N/A</td>
                      <td
                        v-if="appointment.mentor.first_name && appointment.mentor.last_name"
                      >
                        {{ appointment.mentor.first_name }}
                        {{ appointment.mentor.last_name }}
                      </td>
                      <td v-else>Mentor</td>
                      <!-- <td>{{ appointment.id }}</td> -->
                      <td>{{ appointment.date }}</td>
                      <td>{{ appointment.time }}</td>
                      <td>{{ appointment.appointment_type_string }}</td>
                      <td>
                        <span class="text-success fw-400"
                          >{{currency_symbol}} {{ appointment.payment }}</span
                        >
                      </td>
                      <td v-if="appointment.is_paid == 1">
                        <span class="text-primary me-2"
                          ><i class="fas fa-check"></i
                        ></span>
                        {{ $t("appointment_log.tab.pending.column.paid_text") }}
                      </td>
                      <td v-if="appointment.is_paid == 0">
                        <span class="text-danger me-2"
                          ><i class="fas fa-times"></i
                        ></span>
                        {{
                          $t("appointment_log.tab.pending.column.unpaid_text")
                        }}
                      </td>
                      <td v-if="appointment.appointment_status == 0">
                        {{
                          $t(
                            "appointment_log.tab.pending.column.appointment_status.pending"
                          )
                        }}
                      </td>
                      <td v-if="appointment.appointment_status == 1">
                        {{
                          $t(
                            "appointment_log.tab.pending.column.appointment_status.accepted"
                          )
                        }}
                      </td>
                      <td v-if="appointment.appointment_status == 2">
                        {{
                          $t(
                            "appointment_log.tab.pending.column.appointment_status.completed"
                          )
                        }}
                      </td>
                      <td v-if="appointment.appointment_status == 3">
                        {{
                          $t(
                            "appointment_log.tab.pending.column.appointment_status.cancel"
                          )
                        }}
                      </td>
                      <td>
                        <a
                          :href="`${
                            url + '/mentee/appointment-log-detail/' + appointment.id
                          }`"
                          class="btn btn-primary mb-md-0 mb-2 btn-sm"
                          >{{
                            $t(
                              "appointment_log.tab.pending.button.view_details"
                            )
                          }}</a>
                            <a
                            v-show="appointment.reschudlable"
                          v-on:click="rescheduleAppointment(appointment.id,appointment.mentor_id,appointment.appointment_type_string)"
                            class="btn btn-secondary mb-md-0 mb-2 btn-sm"
                              >{{
                                $t(
                                        "appointment_log.tab.pending.button.re_schedule"
                                          )
                                }}</a>

                      </td>
                    </tr>
                    <tr v-if="allAcceptedAppointmentsFilter.length == 0 && !loading">
                        <td colspan="9" class="text-center">
                            No record found
                        </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div
              class="
                btn-load-more
                d-flex
                justify-content-center
                align-items-center
              "
            >
              <v-page
                :total-row="allAcceptedAppointments.length"
                align="left"
                v-model="current"
                @page-change="allAcceptedAppointmentsChange"
                :page-size-menu="[10, 20, 30]"
                v-if="!loading && allAcceptedAppointments.length>0"
              ></v-page>
            </div>
          </div>
        </div>
              </div>

               <!-- cancelled appointmnets -->

              <div
              class="tab-pane fade"
              id="pills-cancelapp"
              role="tabpanel"
              aria-labelledby="pills-cancelapp-tab"
            >
        <div class="row">
          <div class="col-md-12">
            <div class="bg-white px-2">
              <div class="row">
                <div class="col-md-4">

                </div>
<div class="col-md-4">

                </div>
                <div class="col-lg-4">
                  <div class="p-3 py-2">
                    <div class="d-flex align-items-center h-100">
                      <div class="w-25">
                        <label for="filter" class="pe-2 text-primary fw-bold"
                          >Search:</label
                        >
                      </div>
                      <div class="w-100">
                        <!-- <form action=""> -->
                          <input
                            type="text"
                            name=""
                            id=""
                            class="form-control border"
                            :placeholder="
                              $t(
                                'appointment_log.tab.all_appointments.search.label'
                              )
                            "
                            v-model="search_cancelled"
                            @change="searchCancelledAppointments"
                          />
                          <div class="search-icon position-relative">
                            <i
                              class="fa-solid fa-magnifying-glass text-primary"
                            ></i>
                          </div>
                        <!-- </form> -->
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="bg-white mt-4">
              <div class="table-responsive">
                <table
                  class="table table-striped table-borderless align-middle mb-0"
                >
                  <thead class="align-middle">
                    <!-- head -->
                    <tr class="bg-primary text-white fw-bold">
                      <td class="p-3">
                        {{ $t("appointment_log.tab.pending.column.question") }}
                      </td>
                      <td class="p-3">
                        {{ $t("appointment_log.tab.pending.column.name") }}
                      </td>
                      <td class="p-3">
                        {{ $t("appointment_log.tab.pending.column.date") }}
                      </td>
                      <td class="p-3">
                        {{ $t("appointment_log.tab.pending.column.time") }}
                      </td>
                      <td class="p-3">
                        {{ $t("appointment_log.tab.pending.column.type") }}
                      </td>
                      <td class="p-3">
                        {{ $t("appointment_log.tab.pending.column.amount") }}
                      </td>
                      <td class="p-3">
                        {{ $t("appointment_log.tab.pending.column.p_Status") }}
                      </td>
                      <td class="p-3">
                        {{ $t("appointment_log.tab.pending.column.status") }}
                      </td>
                      <td class="p-3">
                        {{ $t("appointment_log.tab.pending.column.action") }}
                      </td>
                    </tr>
                    <!-- head end -->
                  </thead>
                  <tbody class="text-dark">
                    <tr v-if="loading">
                      <td align="center" colspan="9"><img src="/assets/images/loader.gif" height="100px" alt=""></td>
                    </tr>
                    <tr
                      v-else
                      v-for="appointment in allCancelledAppointmentsFilter"
                      :key="appointment.id"
                    >
                      <td
                        v-if="appointment.questions != null"
                        class="mb-0"

                      >
                         <div class="wrap-ques ps-2
                        ">
                          {{ appointment.questions }}</div>
                      </td>
                      <td v-else>N/A</td>
                      <td
                        v-if="appointment.mentor.first_name && appointment.mentor.last_name"
                      >
                        {{ appointment.mentor.first_name }}
                        {{ appointment.mentor.last_name }}
                      </td>
                      <td v-else>Mentor</td>
                      <!-- <td>{{ appointment.id }}</td> -->
                      <td>{{ appointment.date }}</td>
                      <td>{{ appointment.time }}</td>
                      <td>{{ appointment.appointment_type_string }}</td>
                      <td>
                        <span class="text-success fw-400"
                          >{{currency_symbol}} {{ appointment.payment }}</span
                        >
                      </td>
                      <td v-if="appointment.is_paid == 1">
                        <span class="text-primary me-2"
                          ><i class="fas fa-check"></i
                        ></span>
                        {{ $t("appointment_log.tab.pending.column.paid_text") }}
                      </td>
                      <td v-if="appointment.is_paid == 0">
                        <span class="text-danger me-2"
                          ><i class="fas fa-times"></i
                        ></span>
                        {{
                          $t("appointment_log.tab.pending.column.unpaid_text")
                        }}
                      </td>
                      <td v-if="appointment.appointment_status == 0">
                        {{
                          $t(
                            "appointment_log.tab.pending.column.appointment_status.pending"
                          )
                        }}
                      </td>
                      <td v-if="appointment.appointment_status == 1">
                        {{
                          $t(
                            "appointment_log.tab.pending.column.appointment_status.accepted"
                          )
                        }}
                      </td>
                      <td v-if="appointment.appointment_status == 2">
                        {{
                          $t(
                            "appointment_log.tab.pending.column.appointment_status.completed"
                          )
                        }}
                      </td>
                      <td v-if="appointment.appointment_status == 3">
                        {{
                          $t(
                            "appointment_log.tab.pending.column.appointment_status.cancel"
                          )
                        }}
                      </td>
                      <td>
                        <a
                          :href="`${
                            url + '/mentee/appointment-log-detail/' + appointment.id
                          }`"
                          class="btn btn-primary mb-md-0 mb-2 btn-sm"
                          >{{
                            $t(
                              "appointment_log.tab.pending.button.view_details"
                            )
                          }}</a
                        >

                      </td>
                    </tr>
                    <tr v-if="allCancelledAppointmentsFilter.length == 0 && !loading">
                        <td colspan="9" class="text-center">
                            No record found
                        </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div
              class="
                btn-load-more
                d-flex
                justify-content-center
                align-items-center
              "
            >
              <v-page
                :total-row="allCancelledAppointments.length"
                align="left"
                v-model="current"
                @page-change="allCancelledAppointmentsChange"
                :page-size-menu="[10, 20, 30]"
                v-if="!loading && allCancelledAppointments.length>0"
              ></v-page>
            </div>
          </div>
        </div>
              </div>

                  <!-- completed appointmnets -->

              <div
              class="tab-pane fade"
              id="pills-compapp"
              role="tabpanel"
              aria-labelledby="pills-compapp-tab"
            >
        <div class="row">
          <div class="col-md-12">
            <div class="bg-white px-2">
              <div class="row">
                <div class="col-md-4">

                </div>
<div class="col-md-4">

                </div>
                <div class="col-lg-4">
                  <div class="p-3 py-2">
                    <div class="d-flex align-items-center h-100">
                      <div class="w-25">
                        <label for="filter" class="pe-2 text-primary fw-bold"
                          >Search:</label
                        >
                      </div>
                      <div class="w-100">
                        <!-- <form action=""> -->
                          <input
                            type="text"
                            name=""
                            id=""
                            class="form-control border"
                            :placeholder="
                              $t(
                                'appointment_log.tab.all_appointments.search.label'
                              )
                            "
                            v-model="search_complete"
                            @change="searchCompleteAppointments"
                          />
                          <div class="search-icon position-relative">
                            <i
                              class="fa-solid fa-magnifying-glass text-primary"
                            ></i>
                          </div>
                        <!-- </form> -->
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="bg-white mt-4">
              <div class="table-responsive">
                <table
                  class="table table-striped table-borderless align-middle mb-0"
                >
                  <thead class="align-middle">
                    <!-- head -->
                    <tr class="bg-primary text-white fw-bold">
                      <td class="p-3">
                        {{ $t("appointment_log.tab.pending.column.question") }}
                      </td>
                      <td class="p-3">
                        {{ $t("appointment_log.tab.pending.column.name") }}
                      </td>
                      <td class="p-3">
                        {{ $t("appointment_log.tab.pending.column.date") }}
                      </td>
                      <td class="p-3">
                        {{ $t("appointment_log.tab.pending.column.time") }}
                      </td>
                      <td class="p-3">
                        {{ $t("appointment_log.tab.pending.column.type") }}
                      </td>
                      <td class="p-3">
                        {{ $t("appointment_log.tab.pending.column.amount") }}
                      </td>
                      <td class="p-3">
                        {{ $t("appointment_log.tab.pending.column.p_Status") }}
                      </td>
                      <td class="p-3">
                        {{ $t("appointment_log.tab.pending.column.status") }}
                      </td>
                      <td class="p-3">
                        {{ $t("appointment_log.tab.pending.column.action") }}
                      </td>
                    </tr>
                    <!-- head end -->
                  </thead>
                  <tbody class="text-dark">
                    <tr v-if="loading">
                      <td align="center" colspan="9"><img src="/assets/images/loader.gif" height="100px" alt=""></td>
                    </tr>
                    <tr
                      v-else
                      v-for="appointment in allAppointmentsFilter"
                      :key="appointment.id"
                    >
                      <td
                        v-if="appointment.questions != null"
                        class="mb-0"

                      >
                         <div class="wrap-ques ps-2
                        ">
                          {{ appointment.questions }}</div>
                      </td>
                      <td v-else>N/A</td>
                      <td
                        v-if="appointment.mentor.first_name && appointment.mentor.last_name"
                      >
                        {{ appointment.mentor.first_name }}
                        {{ appointment.mentor.last_name }}
                      </td>
                      <td v-else>Mentor</td>
                      <!-- <td>{{ appointment.id }}</td> -->
                      <td>{{ appointment.date }}</td>
                      <td>{{ appointment.time }}</td>
                      <td>{{ appointment.appointment_type_string }}</td>
                      <td>
                        <span class="text-success fw-400"
                          >{{currency_symbol}} {{ appointment.payment }}</span
                        >
                      </td>
                      <td v-if="appointment.is_paid == 1">
                        <span class="text-primary me-2"
                          ><i class="fas fa-check"></i
                        ></span>
                        {{ $t("appointment_log.tab.pending.column.paid_text") }}
                      </td>
                      <td v-if="appointment.is_paid == 0">
                        <span class="text-danger me-2"
                          ><i class="fas fa-times"></i
                        ></span>
                        {{
                          $t("appointment_log.tab.pending.column.unpaid_text")
                        }}
                      </td>
                      <td v-if="appointment.appointment_status == 0">
                        {{
                          $t(
                            "appointment_log.tab.pending.column.appointment_status.pending"
                          )
                        }}
                      </td>
                      <td v-if="appointment.appointment_status == 1">
                        {{
                          $t(
                            "appointment_log.tab.pending.column.appointment_status.accepted"
                          )
                        }}
                      </td>
                      <td v-if="appointment.appointment_status == 2">
                        {{
                          $t(
                            "appointment_log.tab.pending.column.appointment_status.completed"
                          )
                        }}
                      </td>
                      <td v-if="appointment.appointment_status == 3">
                        {{
                          $t(
                            "appointment_log.tab.pending.column.appointment_status.cancel"
                          )
                        }}
                      </td>
                      <td>
                        <a
                          :href="`${
                            url + '/mentee/appointment-log-detail/' + appointment.id
                          }`"
                          class="btn btn-primary mb-md-0 mb-2 btn-sm"
                          >{{
                            $t(
                              "appointment_log.tab.pending.button.view_details"
                            )
                          }}</a>
                           <a
                          :href="`${
                            url + '/completed-appointment-invoice/' + appointment.id
                          }`"
                          target="_blank"
                          class="btn btn-primary mb-md-0 mb-2 btn-sm"
                          >
                          {{$t('appointment_log.tab.pending.button.download_invoice')}}
                          </a
                        >

                      </td>
                    </tr>
                    <tr v-if="allAppointmentsFilter.length == 0 && !loading">
                        <td colspan="9" class="text-center">
                            No record found
                        </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div
              class="
                btn-load-more
                d-flex
                justify-content-center
                align-items-center
              "
            >
              <v-page
                :total-row="allAppointments.length"
                align="left"
                v-model="current"
                @page-change="allAppointmentsChange"
                :page-size-menu="[10, 20, 30]"
                v-if="!loading"
              ></v-page>
            </div>
          </div>
        </div>
              </div>


          </div>
      </div>
    </section>

  </div>
</template>
<script>
import loginMixin from "../mixins/loginMixin.js";
export default {
  props: ["url","currency_symbol"],
  mixins: [loginMixin],
  data() {
    return {
        allCancelledAppointments:[],
        allAcceptedAppointments:[],
      allPendingAppointments: [],
      allAppointments: [],
      loading: true,
      search_cancelled:"",
      search_accepted:"",
      search_pending: "",
      search_complete: "",
      selectFilter: 4,
      allCancelledAppointmentsFilter:[],
      allAcceptedAppointmentsFilter:[],
      allPendingAppointmentsFilter: [],
      allAppointmentsFilter: [],
      current: 0,
      pagination: {
        pageNumber: 1,
        pageSize: 10,
      },
    };
  },
  watch: {
    search_complete: {
      handler(val) {
        if (val) {
        } else {
          this.searchCompleteAppointments();
        }
      },
      deep: true,
      immediate: true,
    },
    search_pending:{
        handler(val){
             if (val) {
        } else {
          this.searchPendingAppointments();
        }

        },
        deep: true,
      immediate: true,
    },
    search_accepted:{
        handler(val){
             if (val) {
        } else {
          this.searchAcceptedAppointments();
        }

        },
        deep: true,
      immediate: true,
    },
    search_cancelled:{
        handler(val){
             if (val) {
        } else {
          this.searchCancelledAppointments();
        }

        },
        deep: true,
      immediate: true,
    }
  },
  methods: {
    async rescheduleAppointment(appointment_id,mentor_id,type){
    window.location.href=this.url+'/appointment-schedule/'+mentor_id+"/"+appointment_id;
    },
    allAppointmentsChange(pInfo) {
      this.allAppointmentsFilter.splice(0, this.allAppointmentsFilter.length);
      let start = 0,
        end = 0;
      start = pInfo.pageSize * (pInfo.pageNumber - 1);
      end = start + pInfo.pageSize;
      if (end > this.allAppointments.length) end = this.allAppointments.length;
      for (let i = start; i < end; i++) {
        this.allAppointmentsFilter.push(this.allAppointments[i]);
      }
    },
    allPendingAppointmentsChange(pInfo) {
      this.allPendingAppointmentsFilter.splice(0, this.allPendingAppointmentsFilter.length);
      let start = 0,
        end = 0;
      start = pInfo.pageSize * (pInfo.pageNumber - 1);
      end = start + pInfo.pageSize;
      if (end > this.allPendingAppointments.length) end = this.allPendingAppointments.length;
      for (let i = start; i < end; i++) {
        this.allPendingAppointmentsFilter.push(this.allPendingAppointments[i]);
      }
    },
    allAcceptedAppointmentsChange(pInfo) {
      this.allAcceptedAppointmentsFilter.splice(0, this.allAcceptedAppointmentsFilter.length);
      let start = 0,
        end = 0;
      start = pInfo.pageSize * (pInfo.pageNumber - 1);
      end = start + pInfo.pageSize;
      if (end > this.allAcceptedAppointments.length) end = this.allAcceptedAppointments.length;
      for (let i = start; i < end; i++) {
        this.allAcceptedAppointmentsFilter.push(this.allAcceptedAppointments[i]);
      }
    },
    allCancelledAppointmentsChange(pInfo) {
      this.allCancelledAppointmentsFilter.splice(0, this.allCancelledAppointmentsFilter.length);
      let start = 0,
        end = 0;
      start = pInfo.pageSize * (pInfo.pageNumber - 1);
      end = start + pInfo.pageSize;
      if (end > this.allCancelledAppointments.length) end = this.allCancelledAppointments.length;
      for (let i = start; i < end; i++) {
        this.allCancelledAppointmentsFilter.push(this.allCancelledAppointments[i]);
      }
    },
    async fetchCompletedAppointments() {
      this.loading = true;
      const params = {
        token: 123,
        mentee_id: this.User.user_id,
        status:2
      };
      const res = await axios.get("/api/menteeAppointments", { params });

      if (res.data && res.data.Status) {
            this.allAppointments = res.data.data.appointments.data;
        this.loading = false;
      }
    },
    async fetchPendingAppointments() {
      this.loading = true;
      const params = {
        token: 123,
        mentee_id: this.User.user_id,
        status:0
      };
      const res = await axios.get("/api/menteeAppointments", { params });

      if (res.data && res.data.Status) {
            this.allPendingAppointments = res.data.data.appointments.data;
        this.loading = false;
      }
    },
    async fetchAcceptedAppointments() {
      this.loading = true;
      const params = {
        token: 123,
        mentee_id: this.User.user_id,
        status:1
      };
      const res = await axios.get("/api/menteeAppointments", { params });

      if (res.data && res.data.Status) {
            this.allAcceptedAppointments = res.data.data.appointments.data;
        this.loading = false;
      }
    },
    async fetchCancelledAppointments() {
      this.loading = true;
      const params = {
        token: 123,
        mentee_id: this.User.user_id,
        status:3
      };
      const res = await axios.get("/api/menteeAppointments", { params });

      if (res.data && res.data.Status) {
        //   if(res.data.data.appointments.data)
            this.allCancelledAppointments = res.data.data.appointments.data;
        this.loading = false;
      }
    },
    async searchCompleteAppointments() {
      this.loading = true;
      const params = {
        token: 123,
        search: this.search_complete,
        mentee_id: this.User.user_id,
      };
      const res = await axios.get("/api/search-appointment-mentee", { params });

      if (res.data && res.data.Status) {
        this.allAppointments = res.data.data.results;
        this.loading = false;
      }
    },
    async searchPendingAppointments() {
      this.loading = true;
      const params = {
        token: 123,
        search: this.search_complete,
        mentee_id: this.User.user_id,
      };
      const res = await axios.get("/api/search-appointment-mentee", { params });

      if (res.data && res.data.Status) {
        this.allPendingAppointments = res.data.data.results;
        this.loading = false;
      }
    },
     async searchAcceptedAppointments() {
      this.loading = true;
      const params = {
        token: 123,
        search: this.search_complete,
        mentee_id: this.User.user_id,
      };
      const res = await axios.get("/api/search-appointment-mentee", { params });

      if (res.data && res.data.Status) {
        this.allAcceptedAppointments = res.data.data.results;
        this.loading = false;
      }
    },
    async searchCancelledAppointments() {
      this.loading = true;
      const params = {
        token: 123,
        search: this.search_complete,
        mentee_id: this.User.user_id,
      };
      const res = await axios.get("/api/search-appointment-mentee", { params });

      if (res.data && res.data.Status) {
        this.allCancelledAppointments = res.data.data.results;
        this.loading = false;
      }
    },

    async selectedFilter() {
      this.loading = true;
      const params = {
        token: 123,
        appointment_status: this.selectFilter,
        mentee_id: this.User.user_id,
      };
      const res = await axios.get("/api/filter-appointment-mentee", { params });

      if (res.data && res.data.Status) {
        this.allAppointments = res.data.data.results;
        this.loading = false;
      }
    },
  },
  created() {
    this.checkLoggedIn();
    if (this.is_loggedIn && this.User.role == "Mentee") {
    } else {
      window.location.href = this.url + "/login";
      this.$toasted.error("Please Login First");
    }
    this.fetchCompletedAppointments();
    this.fetchPendingAppointments();
  },
};
</script>
