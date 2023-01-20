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
              class="nav-item mb-md-0 mb-4 w-20"
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
                    {{ $t("appointment_log.label_1") }}
                </div>
              </button>
            </li>
            <li
              class="nav-item mb-md-0 mb-4 w-20"
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
              class="nav-item mb-md-0 mb-4 w-20"
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
              class="nav-item mb-md-0 mb-4 w-20"
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
            <li
              class="nav-item mb-md-0 mb-4 w-20"
              role="presentation"
            >
              <button
                class="nav-link w-100 p-md-0"
                id="pills-archievedapp-tab"
                data-bs-toggle="pill"
                data-bs-target="#pills-archievedapp"
                type="button"
                role="tab"
                aria-controls="pills-archievedapp"
                aria-selected="false"
                @click="fetchArchivedAppointments"
              >
                <div class="border-top-nav position-relative mb-3">
                  <i class="fas fa-circle position-absolute"></i>
                </div>
                <div class="text-dark mentor-head">
                    {{ $t("appointment_log.label_5") }}

                </div>
              </button>
            </li>
          </ul>
          <div class="tab-content" id="pills-tabContent">
            <!-- pending appointment -->
            <div
              class="tab-pane fade show active"
              id="pills-pending"
              role="tabpanel"
              aria-labelledby="pills-pending-tab"
            >

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
                      <td class="px-2 py-3">
                        {{ $t("appointment_log.tab.pending.column.name") }}
                      </td>
                      <td class="px-2 py-3">
                        {{ $t("appointment_log.tab.pending.column.date") }}
                      </td>
                      <td class="px-2 py-3">
                        {{ $t("appointment_log.tab.pending.column.time") }}
                      </td>
                      <td class="px-2 py-3">
                        {{ $t("appointment_log.tab.pending.column.type") }}
                      </td>
                      <td class="px-2 py-3">
                        {{ $t("appointment_log.tab.pending.column.amount") }}
                      </td>
                      <td class="px-2 py-3">
                        {{ $t("appointment_log.tab.pending.column.p_Status") }}
                      </td>
                      <td class="px-2 py-3">
                        {{ $t("appointment_log.tab.pending.column.status") }}
                      </td>
                      <td class="px-2 py-3">
                        {{ $t("appointment_log.tab.pending.column.action") }}
                      </td>
                    </tr>
                    <!-- head end -->
                  </thead>
                  <tbody class="text-dark">
                    <tr v-if="loading">
                      <td align="center" colspan="9" class="py-5">
                       <div class="spinner-border text-primary" role="status">
                       <span class="visually-hidden"> <img src="/assets/images/loader.gif" height="100px" alt="">
</span>
                       </div>
                      </td>
                    </tr>
                    <tr
                      v-else
                      v-for="appointment in allPendingAppointmentsFilter"
                      :key="appointment.id"
                    >
                      <td
                        v-if="appointment.questions != null"
                      >
                      <div class="wrap-ques ps-2
                        ">
                        {{ appointment.questions }}</div>

                      </td>
                      <td v-else>N/A</td>
                      <td
                        v-if="
                        appointment.mentee.mentee!=null&&
                          appointment.mentee.mentee.identity_hidden == 0 &&
                          appointment.mentee.first_name != null &&
                          appointment.mentee.last_name != null
                        "
                      >
                        {{ appointment.mentee.first_name }}
                        {{ appointment.mentee.last_name }}
                      </td>
                      <td v-else>User</td>
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
                      <td class="w-275">
                        <a
                          :href="`${
                            url + '/mentor/appointment-log-detail/' + appointment.id
                          }`"
                          class="btn btn-primary mb-md-0 mb-2 btn-sm mt-1"
                          >{{
                            $t(
                              "appointment_log.tab.pending.button.view_details"
                            )
                          }}</a
                        >
                        <button
                          type="button"
                          v-if="appointment.appointment_status == 0"
                          v-on:click="acceptAppointment(appointment.id)"
                          class="btn btn-primary mb-md-0 mb-2 btn-sm mt-1"
                        >
                          {{ $t("appointment_log.tab.pending.button.accept") }}
                        </button>
                        <button
                          type="button"
                          v-if="appointment.appointment_status == 0"
                          v-on:click="rejectAppointment(appointment.id)"
                          class="btn btn-danger mb-md-0 mb-2 btn-sm mt-1"
                        >
                          {{ $t("appointment_log.tab.pending.button.reject") }}
                        </button>
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
                @page-change="pendingAppointmentsChange"
                :page-size-menu="[10, 20, 30]"
                v-if="!loading && allPendingAppointments.length>0"
              ></v-page>
            </div>
          </div>
        </div>
            </div>
             <!-- Accepted appointments -->
            <div
              class="tab-pane fade"
              id="pills-acceptapp"
              role="tabpanel"
              aria-labelledby="pills-acceptapp-tab"
            >
        <div class="row">
          <div class="col-md-12">
            <div class="bg-white px-2 py-lg-0 py-3">
              <div class="row">
                <div class="col-lg-4">
                  <div class="p-3 py-2 d-flex align-items-center h-100">

                  </div>
                </div>
                  <div class="col-lg-4"></div>
                <div class="col-lg-4">
                  <div class="p-3 py-2">
                    <div class="d-flex align-items-center h-100">
                      <div class="w-25">
                        <label for="filter" class="pe-2 text-primary fw-bold"
                          >Search:</label
                        >
                      </div>
                      <div class="w-100">

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
                      <td class="px-2 py-3">
                        {{ $t("appointment_log.tab.pending.column.name") }}
                      </td>
                      <td class="px-2 py-3">
                        {{ $t("appointment_log.tab.pending.column.date") }}
                      </td>
                      <td class="px-2 py-3">
                        {{ $t("appointment_log.tab.pending.column.time") }}
                      </td>
                      <td class="px-2 py-3">
                        {{ $t("appointment_log.tab.pending.column.type") }}
                      </td>
                      <td class="px-2 py-3">
                        {{ $t("appointment_log.tab.pending.column.amount") }}
                      </td>
                      <td class="px-2 py-3">
                        {{ $t("appointment_log.tab.pending.column.p_Status") }}
                      </td>
                      <td class="px-2 py-3">
                        {{ $t("appointment_log.tab.pending.column.status") }}
                      </td>
                      <td class="px-2 py-3">
                        {{ $t("appointment_log.tab.pending.column.action") }}
                      </td>
                    </tr>
                    <!-- head end -->
                  </thead>
                  <tbody class="text-dark">
                    <tr v-if="loading">
                      <td align="center" colspan="9" class="py-5">
                       <div class="spinner-border text-primary" role="status">
                       <span class="visually-hidden"><img src="/assets/images/loader.gif" height="100px" alt=""></span>
                       </div>
                      </td>
                    </tr>
                    <tr
                      v-else
                      v-for="appointment in allAcceptedAppointmentsFilter"
                      :key="appointment.id"
                    >
                      <td
                        v-if="appointment.questions != null"
                      >
                      <div class="wrap-ques ps-2
                        ">
                        {{ appointment.questions }}</div>

                      </td>
                      <td v-else>N/A</td>
                      <td
                        v-if="
                        appointment.mentee.mentee!=null&&
                          appointment.mentee.mentee.identity_hidden == 0 &&
                          appointment.mentee.first_name != null &&
                          appointment.mentee.last_name != null
                        "
                      >
                        {{ appointment.mentee.first_name }}
                        {{ appointment.mentee.last_name }}
                      </td>
                      <td v-else>User</td>
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
                      <td class="w-275">
                        <a
                          :href="`${
                            url + '/mentor/appointment-log-detail/' +appointment.id
                          }`"
                          class="btn btn-primary mb-md-0 mb-2 btn-sm mt-1"
                          >{{
                            $t(
                              "appointment_log.tab.pending.button.view_details"
                            )
                          }}</a
                        >


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
                @page-change="acceptedAppointmentsChange"
                :page-size-menu="[10, 20, 30]"
                v-if="!loading && allAcceptedAppointments.length>0"
              ></v-page>
            </div>
          </div>
        </div>
            </div>
            <!-- Cancel appointments -->
            <div
              class="tab-pane fade"
              id="pills-cancelapp"
              role="tabpanel"
              aria-labelledby="pills-cancelapp-tab"
            >
        <div class="row">
          <div class="col-md-12">
            <div class="bg-white px-2 py-lg-0 py-3">
              <div class="row">
                <div class="col-lg-4">
                  <div class="p-3 py-2 d-flex align-items-center h-100">

                  </div>
                </div>
                  <div class="col-lg-4"></div>
                <div class="col-lg-4">
                  <div class="p-3 py-2">
                    <div class="d-flex align-items-center h-100">
                      <div class="w-25">
                        <label for="filter" class="pe-2 text-primary fw-bold"
                          >Search:</label
                        >
                      </div>
                      <div class="w-100">
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
                      <td class="px-2 py-3">
                        {{ $t("appointment_log.tab.pending.column.name") }}
                      </td>
                      <td class="px-2 py-3">
                        {{ $t("appointment_log.tab.pending.column.date") }}
                      </td>
                      <td class="px-2 py-3">
                        {{ $t("appointment_log.tab.pending.column.time") }}
                      </td>
                      <td class="px-2 py-3">
                        {{ $t("appointment_log.tab.pending.column.type") }}
                      </td>
                      <td class="px-2 py-3">
                        {{ $t("appointment_log.tab.pending.column.amount") }}
                      </td>
                      <td class="px-2 py-3">
                        {{ $t("appointment_log.tab.pending.column.p_Status") }}
                      </td>
                      <td class="px-2 py-3">
                        {{ $t("appointment_log.tab.pending.column.status") }}
                      </td>
                      <td class="px-2 py-3">
                        {{ $t("appointment_log.tab.pending.column.action") }}
                      </td>
                    </tr>
                    <!-- head end -->
                  </thead>
                  <tbody class="text-dark">
                    <tr v-if="loading">
                      <td align="center" colspan="9" class="py-5">
                       <div class="spinner-border text-primary" role="status">
                       <span class="visually-hidden"><img src="/assets/images/loader.gif" height="100px" alt=""></span>
                       </div>
                      </td>
                    </tr>
                    <tr
                      v-else
                      v-for="appointment in allCancelledAppointmentsFilter"
                      :key="appointment.id"
                    >
                      <td
                        v-if="appointment.questions != null"
                      >
                      <div class="wrap-ques ps-2
                        ">
                        {{ appointment.questions }}</div>

                      </td>
                      <td v-else>N/A</td>
                      <td
                        v-if="
                        appointment.mentee.mentee!=null&&
                          appointment.mentee.mentee.identity_hidden == 0 &&
                          appointment.mentee.first_name != null &&
                          appointment.mentee.last_name != null
                        "
                      >
                        {{ appointment.mentee.first_name }}
                        {{ appointment.mentee.last_name }}
                      </td>
                      <td v-else>User</td>
                      <!-- <td>{{ appointment.id }}</td> -->
                      <td>{{ appointment.date }}</td>
                      <td>{{ appointment.time }}</td>
                      <td>{{ appointment.appointment_type_string }}</td>
                      <td>
                        <span class="text-success fw-400"
                          >{{currency_symbol}}{{ appointment.payment }}</span
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
                      <td class="w-275">
                        <a
                          :href="`${
                            url + '/mentor/appointment-log-detail/' + appointment.id
                          }`"
                          class="btn btn-primary mb-md-0 mb-2 btn-sm mt-1"
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
                @page-change="cancelledAppointmentsChange"
                :page-size-menu="[10, 20, 30]"
                v-if="!loading && allCancelledAppointments.length>0"
              ></v-page>
            </div>
          </div>
        </div>
            </div>
            <!-- Completed appointments -->
            <div
              class="tab-pane fade"
              id="pills-compapp"
              role="tabpanel"
              aria-labelledby="pills-compapp-tab"
            >
        <div class="row">
          <div class="col-md-12">
            <div class="bg-white px-2 py-lg-0 py-3">
              <div class="row">
                <div class="col-lg-4">
                  <div class="p-3 py-2 d-flex align-items-center h-100">

                  </div>
                </div>
                  <div class="col-lg-4"></div>
                <div class="col-lg-4">
                  <div class="p-3 py-2">
                    <div class="d-flex align-items-center h-100">
                      <div class="w-25">
                        <label for="filter" class="pe-2 text-primary fw-bold"
                          >Search:</label
                        >
                      </div>
                      <div class="w-100">
                        <form action="">
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
                        </form>
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
                      <td class="px-2 py-3">
                        {{ $t("appointment_log.tab.pending.column.name") }}
                      </td>
                      <td class="px-2 py-3">
                        {{ $t("appointment_log.tab.pending.column.date") }}
                      </td>
                      <td class="px-2 py-3">
                        {{ $t("appointment_log.tab.pending.column.time") }}
                      </td>
                      <td class="px-2 py-3">
                        {{ $t("appointment_log.tab.pending.column.type") }}
                      </td>
                      <td class="px-2 py-3">
                        {{ $t("appointment_log.tab.pending.column.amount") }}
                      </td>
                      <td class="px-2 py-3">
                        {{ $t("appointment_log.tab.pending.column.p_Status") }}
                      </td>
                      <td class="px-2 py-3">
                        {{ $t("appointment_log.tab.pending.column.status") }}
                      </td>
                      <td class="px-2 py-3">
                        {{ $t("appointment_log.tab.pending.column.action") }}
                      </td>
                    </tr>
                    <!-- head end -->
                  </thead>
                  <tbody class="text-dark">
                    <tr v-if="loading">
                      <td align="center" colspan="9" class="py-5">
                       <div class="spinner-border text-primary" role="status">
                       <span class="visually-hidden"><img src="/assets/images/loader.gif" height="100px" alt=""></span>
                       </div>
                      </td>
                    </tr>
                    <tr
                      v-else
                      v-for="appointment in allAppointmentsFilter"
                      :key="appointment.id"
                    >
                      <td
                        v-if="appointment.questions != null"
                      >
                      <div class="wrap-ques ps-2
                        ">
                        {{ appointment.questions }}</div>

                      </td>
                      <td v-else>N/A</td>
                      <td
                        v-if="
                        appointment.mentee.mentee!=null&&
                          appointment.mentee.mentee.identity_hidden == 0 &&
                          appointment.mentee.first_name != null &&
                          appointment.mentee.last_name != null
                        "
                      >
                        {{ appointment.mentee.first_name }}
                        {{ appointment.mentee.last_name }}
                      </td>
                      <td v-else>User</td>
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
                      <td class="w-275">
                        <a
                          @click="ArchiveAppointment(appointment.id)"
                          class="btn btn-primary mb-md-0 mb-2 btn-sm mt-1"
                          >{{
                            $t(
                              "appointment_log.archive"
                            )
                          }}</a>
                        <a
                          :href="`${
                            url + '/mentor/appointment-log-detail/' + appointment.id
                          }`"
                          class="btn btn-primary mb-md-0 mb-2 btn-sm mt-1"
                          >{{
                            $t(
                              "appointment_log.tab.pending.button.view_details"
                            )
                          }}</a
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
            <!-- Archived appointments -->
            <div
              class="tab-pane fade"
              id="pills-archievedapp"
              role="tabpanel"
              aria-labelledby="pills-archievedapp-tab"
            >
        <div class="row">
          <div class="col-md-12">
            <div class="bg-white px-2 py-lg-0 py-3">
              <div class="row">

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
                      <td class="px-2 py-3">
                        {{ $t("appointment_log.tab.pending.column.name") }}
                      </td>
                      <td class="px-2 py-3">
                        {{ $t("appointment_log.tab.pending.column.date") }}
                      </td>
                      <td class="px-2 py-3">
                        {{ $t("appointment_log.tab.pending.column.time") }}
                      </td>
                      <td class="px-2 py-3">
                        {{ $t("appointment_log.tab.pending.column.type") }}
                      </td>
                      <td class="px-2 py-3">
                        {{ $t("appointment_log.tab.pending.column.amount") }}
                      </td>
                      <td class="px-2 py-3">
                        {{ $t("appointment_log.tab.pending.column.p_Status") }}
                      </td>
                      <td class="px-2 py-3">
                        {{ $t("appointment_log.tab.pending.column.status") }}
                      </td>
                      <td class="px-2 py-3">
                        {{ $t("appointment_log.tab.pending.column.action") }}
                      </td>
                    </tr>
                    <!-- head end -->
                  </thead>
                  <tbody class="text-dark">
                    <tr v-if="loading">
                      <td align="center" colspan="9" class="py-5">
                       <div class="spinner-border text-primary" role="status">
                       <span class="visually-hidden"><img src="/assets/images/loader.gif" height="100px" alt=""></span>
                       </div>
                      </td>
                    </tr>
                    <tr
                      v-else
                      v-for="appointment in allArchivedAppointments"
                      :key="appointment.id"
                    >
                      <td
                        v-if="appointment.questions != null"
                      >
                      <div class="wrap-ques ps-2
                        ">
                        {{ appointment.questions }}</div>

                      </td>
                      <td v-else>N/A</td>
                      <td
                        v-if="
                        appointment.mentee.mentee!=null&&
                          appointment.mentee.mentee.identity_hidden == 0 &&
                          appointment.mentee.first_name != null &&
                          appointment.mentee.last_name != null
                        "
                      >
                        {{ appointment.mentee.first_name }}
                        {{ appointment.mentee.last_name }}
                      </td>
                      <td v-else>User</td>
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
                      <td>
                        {{
                          $t(
                            "appointment_log.tab.pending.column.appointment_status.archived"
                          )
                        }}
                      </td>
                      <td class="w-275">
                        <a
                          @click="unArchiveAppointment(appointment.id)"
                          class="btn btn-primary mb-md-0 mb-2 btn-sm mt-1"
                          >{{
                            $t(
                              "appointment_log.un_archive"
                            )
                          }}</a>
                        <a
                          :href="`${
                            url + '/mentor/appointment-log-detail/' + appointment.id
                          }`"
                          class="btn btn-primary mb-md-0 mb-2 btn-sm mt-1"
                          >{{
                            $t(
                              "appointment_log.tab.pending.button.view_details"
                            )
                          }}</a>


                      </td>
                    </tr>
                     <tr v-if="allArchivedAppointments.length == 0 && !loading">
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
                :total-row="allArchivedAppointments.length"
                align="left"
                v-model="current"
                @page-change="allArchivedAppointmentsChange"
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
  props: ["url", "currency_symbol"],
  mixins: [loginMixin],
  data() {
    return {
      allPendingAppointments: [],
      allArchivedAppointments: [],
      allAppointments: [],
      loading: true,
      search_pending: "",
      search_complete: "",
      selectFilter: 4,
      allPendingAppointmentsFilter: [],
      allAppointmentsFilter: [],
      allAcceptedAppointments:[],
      allAcceptedAppointmentsFilter:[],
      search_accepted: "",
      allCancelledAppointments:[],
      allCancelledAppointmentsFilter:[],
      search_cancelled:'',
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
    search_accepted: {
      handler(val) {

        if (val) {
        } else {
          this.searchAcceptedAppointments();
        }
      },
      deep: true,
      immediate: true,
    },
    search_cancelled: {
      handler(val) {

        if (val) {
        } else {
          this.searchCancelledAppointments();
        }
      },
      deep: true,
      immediate: true,
    },
  },
  methods: {
    allAppointmentsChange(pInfo) {
      this.allAppointmentsFilter.splice(0, this.allAppointmentsFilter.length);
      let start = 0;
      let end = 0;
      start = pInfo.pageSize * (pInfo.pageNumber - 1);
      end = start + pInfo.pageSize;
      if (end > this.allAppointments.length) end = this.allAppointments.length;
      for (let i = start; i < end; i++) {
        this.allAppointmentsFilter.push(this.allAppointments[i]);
      }
    },
    allArchivedAppointmentsChange(pInfo) {
    },
    pendingAppointmentsChange(pInfo) {
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
    acceptedAppointmentsChange(pInfo) {


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
    cancelledAppointmentsChange(pInfo) {

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
    async fetchCancelledAppointments() {
      this.loading = true;
      const params = {
        token: 123,
        mentor_id: this.User.user_id,
        status:3
      };
      const res = await axios.get("/api/mentorAppointmentsStatusWise", { params });

      if (res.data && res.data.Status) {
        this.allCancelledAppointments = res.data.data.newAppointments.data;


        this.loading = false;
      }
    },
    async fetchAcceptedAppointments() {
      this.loading = true;
      const params = {
        token: 123,
        mentor_id: this.User.user_id,
        status:1
      };
      const res = await axios.get("/api/mentorAppointmentsStatusWise", { params });

      if (res.data && res.data.Status) {
        this.allAcceptedAppointments = res.data.data.newAppointments.data;


        this.loading = false;
      }
    },

    async fetchCompletedAppointments() {
      this.loading = true;
      const params = {
        token: 123,
        mentor_id: this.User.user_id,
        status:2
      };
      const res = await axios.get("/api/mentorAppointments", { params });

      if (res.data && res.data.Status) {
        this.allAppointments = res.data.data.Appointments.data;
        this.loading = false;
      }
    },
    async fetchArchivedAppointments() {
      this.loading = true;
      const params = {
        token: 123,
        mentor_id: this.User.user_id
      };
      const res = await axios.get("/api/mentor/archieve-appointments", { params });
      if (res.data && res.data.Status) {
        this.allArchivedAppointments = res.data.data.archiveAppointments.data;
        this.loading = false;
      }
    },
    async unArchiveAppointment(id) {
      this.loading = true;
      var toast = this.$toasted;
      const params = {
        token: 123,
        mentor_id: this.User.user_id,
        appointment_id:id
      };
    const res = await axios
      .post("/api/mentor/unarchieved-appointment", params)
      .then((res) => {
        if (res.data.Status) {
          this.loading = true;
          toast.success(res.data.msg);
          this.fetchArchivedAppointments();
          this.loading = false;
        }
        if (!res.data.Status) {
          toast.error("Something Went Worng..");
        }
      });
    },
    refreshAppointments(id){
  //     var tabs = document.getElementById('pills-compapp-tab');
      var index = this.allAppointmentsFilter.findIndex((x) => x.id === id);
      this.allAppointmentsFilter.splice(index, 1);
      var index = this.allAppointments.findIndex((x) => x.id === id);
      this.allAppointments.splice(index, 1);
    //   tabs.tab('show');
    },
    async ArchiveAppointment(id) {
      // Completed Archived
      this.loading = true;
      var toast = this.$toasted;
      const params = {
        token: 123,
        mentor_id: this.User.user_id,
        appointment_id:id
      };
    const res = await axios
      .post("/api/mentor/archieved-appointment", params)
      .then((res) => {
        if (res.data.Status) {
          this.loading = true;
          toast.success(res.data.msg);
          this.refreshAppointments(id);
          this.loading = false;
        }
        if (!res.data.Status) {
          toast.error("Something Went Worng..");
        }
      });
    },
    async fetchPendingAppointments() {
      this.loading = true;
      const params = {
        token: 123,
        mentor_id: this.User.user_id,
      };
      const res = await axios.get("/api/newMentorAppointments", { params });

      if (res.data && res.data.Status) {
        this.allPendingAppointments = res.data.data.newAppointments.data;
        // this.allPendingAppointmentsFilter = res.data.data.newAppointments.data;
        this.loading = false;
      }
    },
    async searchCompleteAppointments() {
      this.loading = true;
      const params = {
        token: 123,
        search: this.search_complete,
        mentor_id: this.User.user_id,
      };
      const res = await axios.get("/api/search-appointment", { params });

      if (res.data && res.data.Status) {
        this.allAppointments = res.data.data.results;
        this.loading = false;
      }
    },
    async searchAcceptedAppointments() {
      this.loading = true;
      const params = {
        token: 123,
        search: this.search_accepted,
        mentor_id: this.User.user_id,
        status:1
      };
      const res = await axios.get("/api/search-appointment", { params });

      if (res.data && res.data.Status) {
        this.allAcceptedAppointments = res.data.data.results;
        this.loading = false;
      }
    },
    async searchCancelledAppointments() {
      this.loading = true;
      const params = {
        token: 123,
        search: this.search_accepted,
        mentor_id: this.User.user_id,
        status:3
      };
      const res = await axios.get("/api/search-appointment", { params });

      if (res.data && res.data.Status) {
        this.allCancelledAppointments = res.data.data.results;
        this.loading = false;
      }
    },
    async acceptAppointment(id) {
      var index = this.allPendingAppointmentsFilter.findIndex((x) => x.id === id);
      var toast = this.$toasted;
      const params = {
        token: 123,
        status: 1,
        id: id,
      };
      const res = await axios
        .post("/api/changeAppointmentStatus", params)
        .then((res) => {
          if (res.data.Status) {
            toast.success(res.data.msg);

            this.sendAcceptedAppointmentNotification(
              this.allPendingAppointmentsFilter[index].mentee_id
            );
            this.sendAcceptedAppointmentSms(
              this.allPendingAppointmentsFilter[index].mentee.phone
            );
            this.allPendingAppointmentsFilter.splice(index, 1);
          }
          if (!res.data.Status) {
            toast.error("Please Fill all Fields...");
          }
        });
    },
    async rejectAppointment(id) {
      var index = this.allPendingAppointmentsFilter.findIndex((x) => x.id === id);
      var toast = this.$toasted;
      var self = this;
      const params = {
        token: 123,
        status: 3,
        id: id,
      };
      const res = await axios
        .post("/api/changeAppointmentStatus", params)
        .then((res) => {
          if (res.data.Status) {
            toast.success(res.data.msg);
            this.sendRejectedAppointmentNotification(
              this.allPendingAppointmentsFilter[index].mentee_id
            );
              this.sendRejectedAppointmentSms(
               this.allPendingAppointmentsFilter[index].mentee.phone
            );
            this.allPendingAppointmentsFilter.splice(index, 1);
          }
          if (!res.data.Status) {
            toast.error("Please Fill all Fields...");
          }
        });
    },
    async sendAcceptedAppointmentNotification(mentee_id) {
      const params = {
        token: 123,
        user_id: mentee_id,
        body: "Click here to See your Appointment",
        title: "Your Appointment is Accepted.",
        link: "/mentor/appointment/log/",
      };
      const res = await axios
        .post("/api/send-web-notification", params)
        .then((res) => {});
    },
    async sendRejectedAppointmentNotification(mentee_id) {
      const params = {
        token: 123,
        user_id: mentee_id,
        body: "Click here to See your Appointment",
        title: "Your Appointment is Rejected.",
        link: "/mentor/appointment/log/",
      };
      const res = await axios
        .post("/api/send-web-notification", params)
        .then((res) => {});

    },
    async sendAcceptedAppointmentSms(phone) {
      const params = {
        token: 123,
        phone: phone,
        message: "Your Appointment is Accepted."
      };
      const res = await axios
        .post("/api/send-sms", params)
        .then((res) => {});
    },
     async sendRejectedAppointmentSms(phone) {
      const params = {
        token: 123,
        phone: phone,
        message: "New Appointment for You."
      };
      const res = await axios
        .post("/api/send-sms", params)
        .then((res) => {});
    },
    async selectedFilter() {
      this.loading = true;
      const params = {
        token: 123,
        appointment_status: this.selectFilter,
        mentor_id: this.User.user_id,
      };
      const res = await axios.get("/api/filter-appointment", { params });

      if (res.data && res.data.Status) {
        this.allAppointments = res.data.data.results;
        this.loading = false;
      }
    },
  },
  created() {
    this.checkLoggedIn();
    if (this.is_loggedIn && this.User.role == "Mentor") {
    } else {
      window.location.href = this.url + "/login";
      this.$toasted.error("Please Login First");
    }
    this.fetchCompletedAppointments();
     this.fetchPendingAppointments();

  },
};
</script>
