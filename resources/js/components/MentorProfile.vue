<template>
  <section class="mentor-profile">
    <div class="container">
      <div class="row mb-5">
        <div class="col-lg-2 col-md-3 col-6 w-11">
          <div class="profile-img-shape-sm">
            <div class="shape-sm"></div>
            <div
              class="
                file-upload-div-sm
                p-0
                d-flex
                justify-content-center
                align-items-center
                position-relative
                flex-column
              "
            >
              <img
                v-if="profile.image_path"
                :src="profile.image_path"
                alt=""
                class="img-fluid"
              />
              <img
                v-else
                src="/assets/images/profile_placeholder.png"
                alt=""
                class="img-fluid"
              />
            </div>
          </div>
        </div>
        <div class="col-md-4 col-6">
          <div class="info d-flex justify-content-center h-100 flex-column">
            <span class="text-primary mt-5 mt-md-0 fw-500">
              {{ $t("mentor.profile.general.welcome") }}
            </span>
            <h4 class="text-primary fw-bold">
              {{ profile.first_name }}
              {{ profile.last_name }}
            </h4>
          </div>
        </div>
        <div class="col-lg-6 col-md-5 col-11 mt-md-0 mt-4 status">
          <label>Status</label>
          <label class="text-capitalize"
            >{{ show_status }}
            <i
              class="fa-solid fa-circle fs-9"
              :class="show_status == 'offline' ? 'text-danger' : 'text-success'"
            ></i
          ></label>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <!-- progress bar -->
          <ul
            class="nav nav-pills mentor-profile-tabs"
            id="pills-tab"
            role="tablist"
          >
            <li class="nav-item mb-md-0 mb-4 w-20" role="presentation">
              <button
                class="nav-link active w-100 p-md-0"
                id="pills-general-tab"
                data-bs-toggle="pill"
                data-bs-target="#pills-general"
                type="button"
                role="tab"
                aria-controls="pills-general"
                aria-selected="true"
                v-on:click="generalTab()"
              >
                <div class="border-top-nav position-relative mb-3">
                  <i class="fas fa-circle position-absolute"></i>
                </div>
                <div class="text-dark mentor-head">
                  {{ $t("mentor.profile.general.title") }}
                </div>
              </button>
            </li>
            <li class="nav-item mb-md-0 mb-4 w-20" role="presentation">
              <button
                class="nav-link w-100 p-md-0 disabled"
                id="pills-educational-tab"
                data-bs-toggle="pill"
                data-bs-target="#pills-educational"
                type="button"
                role="tab"
                aria-controls="pills-educational"
                aria-selected="false"
                v-on:click="educationalTab()"
              >
                <div class="border-top-nav position-relative mb-3">
                  <i class="fas fa-circle position-absolute"></i>
                </div>
                <div class="text-dark mentor-head">
                  {{ $t("mentor.profile.sections.step2.sub_heading") }}
                </div>
              </button>
            </li>
            <li class="nav-item mb-md-0 mb-4 w-20" role="presentation">
              <button
                class="nav-link w-100 p-md-0 disabled"
                id="pills-experience-tab"
                data-bs-toggle="pill"
                data-bs-target="#pills-experience"
                type="button"
                role="tab"
                aria-controls="pills-experience"
                aria-selected="false"
                v-on:click="experienceTab()"
              >
                <div class="border-top-nav position-relative mb-3">
                  <i class="fas fa-circle position-absolute"></i>
                </div>
                <div class="text-dark mentor-head">
                  {{ $t("mentor.profile.experience.title") }}
                </div>
              </button>
            </li>
            <li
              class="nav-item col-md-2 col-12 mb-md-0 mb-4 w-20"
              role="presentation"
            >
              <button
                class="nav-link w-100 p-md-0 disabled"
                id="pills-skills-tab"
                data-bs-toggle="pill"
                data-bs-target="#pills-skills"
                type="button"
                role="tab"
                aria-controls="pills-skills"
                aria-selected="true"
                v-on:click="skillsTab()"
              >
                <div class="border-top-nav position-relative mb-3">
                  <i class="fas fa-circle position-absolute"></i>
                </div>
                <div class="text-dark mentor-head">
                  {{ $t("mentor.profile.skill.title") }}
                </div>
              </button>
            </li>

            <li class="nav-item mb-md-0 mb-4 w-20" role="presentation">
              <button
                class="nav-link w-100 p-md-0 disabled"
                id="pills-acc-tab"
                data-bs-toggle="pill"
                data-bs-target="#pills-acc"
                type="button"
                role="tab"
                aria-controls="pills-acc"
                aria-selected="true"
                v-on:click="accTab()"
              >
                <div class="border-top-nav position-relative mb-3">
                  <i class="fas fa-circle position-absolute"></i>
                </div>
                <div class="text-dark mentor-head">
                  {{ $t("mentor.profile.account_information.title") }}
                </div>
              </button>
            </li>
          </ul>
          <!-- progress bar end -->
        </div>
        <div class="col-md-12">
          <div class="tab-content" id="pills-tabContent">
            <!-- general info -->
            <div
              class="tab-pane fade show active"
              id="pills-general"
              role="tabpanel"
              aria-labelledby="pills-general-tab"
            >
              <div class="row">
                <div class="col-md-3 border-end-c">
                  <div class="profile-img-shape">
                    <div class="shape"></div>

                    <div
                      class="
                        file-upload-div
                        d-flex
                        justify-content-center
                        align-items-center
                        position-relative
                        flex-column
                      "
                    >
                      <i
                        class="fas fa-trash text-danger"
                        v-if="profile.image_view"
                        @click="removeImage"
                      ></i>
                      <div class="img-wrap">
                        <img
                          v-if="profile.image_view"
                          :src="profile.image_view"
                          width="100px"
                          height="82px"
                          alt=""
                          @click="previewImage"
                          class="img-fluid"
                        />
                        <img
                          v-else
                          :src="`${
                            profile.image_path
                              ? url + profile.image_path
                              : '/assets/images/mentor-profile-img.png'
                          }`"
                          alt=""
                          class="img-fluid"
                        />
                      </div>
                      <div class="upload-btn-wrapper">
                        <button
                          class="
                            btn btn-upload
                            d-flex
                            justify-content-center
                            border-0
                            bg-transparent
                          "
                        >
                          <!-- Upload File -->
                          {{ $t("mentor.profile.general.upload_file") }}
                        </button>
                        <input
                          type="file"
                          id="picture"
                          ref="picture"
                          @change="processFile($event)"
                          name="picture"
                        />
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-9">
                  <form
                    action=""
                    class="px-md-4 mt-md-0 mt-5"
                    @submit="submitProfileInfo"
                  >
                    <div class="row">
                      <div class="col-lg-12 mb-4">
                        <toggle-button
                          v-model="profile.online_status"
                          @change="onStatusChangeEventHandler"
                          :color="{
                            checked: '#73bd49',
                            unchecked: '#6c757d',
                          }"
                        />
                        <label
                          class="form-check-label ms-2"
                          for="flexSwitchCheckDefault"
                        >
                          {{ $t("mentor.profile.general.status") }}
                        </label>
                      </div>
                      <div class="col-md-6 position-relative">
                        <label for="" class="text-primary mb-2">
                          {{
                            $t("mentor.profile.general.place_holder.first_name")
                          }}
                        </label>
                        <input
                          type="text"
                          placeholder="Enter your first name"
                          class="form-control border"
                          v-model="profile.first_name"
                          :class="
                            errors && errors.first_name ? 'border-danger' : ''
                          "
                        />
                        <p
                          v-if="errors && errors.first_name"
                          class="text-danger position-absolute small"
                        >
                          {{ errors.first_name[0] }}
                        </p>
                      </div>
                      <div class="col-md-6 position-relative">
                        <label for="" class="text-primary mb-2 mt-md-0 mt-4">
                          {{
                            $t("mentor.profile.general.place_holder.last_name")
                          }}
                        </label>
                        <input
                          type="text"
                          placeholder="Enter your last name"
                          class="form-control border"
                          v-model="profile.last_name"
                          :class="
                            errors && errors.last_name ? 'border-danger' : ''
                          "
                        />
                        <p
                          v-if="errors && errors.last_name"
                          class="text-danger position-absolute small"
                        >
                          {{ errors.last_name[0] }}
                        </p>
                      </div>
                      <div class="col-md-6 position-relative">
                        <label for="" class="text-primary mb-2 mt-4">
                          {{
                            $t(
                              "mentor.profile.general.place_holder.father_name"
                            )
                          }}
                        </label>
                        <input
                          type="text"
                          placeholder="Enter your Father name"
                          class="form-control border"
                          v-model="profile.f_name"
                          :class="
                            errors && errors.father_name ? 'border-danger' : ''
                          "
                        />
                        <p
                          v-if="errors && errors.father_name"
                          class="text-danger position-absolute small"
                        >
                          {{ errors.father_name[0] }}
                        </p>
                      </div>
                      <div class="col-md-6 position-relative">
                        <label for="" class="text-primary mb-2 mt-4">
                          {{ $t("mentor.profile.general.place_holder.cnic") }}
                        </label>
                        <input
                          type="number"
                          placeholder="Enter your cnic"
                          class="form-control border"
                          v-model="profile.cnic"
                          :class="errors && errors.cnic ? 'border-danger' : ''"
                        />
                        <p
                          v-if="errors && errors.cnic"
                          class="text-danger position-absolute small"
                        >
                          {{ errors.cnic[0] }}
                        </p>
                      </div>
                      <div class="col-md-3 position-relative">
                        <label for="" class="text-primary mb-2 mt-4">
                          {{
                            $t("mentor.profile.general.place_holder.gender1")
                          }}
                        </label>
                        <div class="custom-select">
                          <select
                            class="form-select border"
                            aria-label="Default select example"
                            v-model="profile.gender"
                            :class="
                              errors && errors.gender ? 'border-danger' : ''
                            "
                          >
                            <option selected value="">
                              {{
                                $t(
                                  "mentor.profile.general.place_holder.gender1"
                                )
                              }}
                            </option>
                            <option value="male">
                              {{
                                $t(
                                  "mentor.profile.general.place_holder.gender.male"
                                )
                              }}
                            </option>
                            <option value="female">
                              {{
                                $t(
                                  "mentor.profile.general.place_holder.gender.female"
                                )
                              }}
                            </option>
                          </select>
                          <p
                            v-if="errors && errors.gender"
                            class="text-danger position-absolute small"
                          >
                            {{ errors.gender[0] }}
                          </p>
                        </div>
                      </div>
                      <div class="col-md-3 position-relative">
                        <label for="" class="text-primary mb-2 mt-4">
                          {{
                            $t(
                              "mentor.profile.general.place_holder.date_of_birth"
                            )
                          }}
                        </label>
                        <input
                          type="date"
                          max="2022-04-04"
                          placeholder="Enter your cnic"
                          class="form-control border"
                          v-model="profile.dob"
                          :class="errors && errors.dob ? 'border-danger' : ''"
                        />
                        <p
                          v-if="errors && errors.dob"
                          class="text-danger position-absolute small"
                        >
                          {{ errors.dob[0] }}
                        </p>
                      </div>
                      <div class="col-md-6 position-relative">
                        <label for="" class="text-primary mb-2 mt-4">
                          {{
                            $t("mentor.profile.general.place_holder.country")
                          }}
                        </label>
                        <div class="custom-select">
                          <select
                            class="form-select border"
                            aria-label="Default select example"
                            v-model="profile.country"
                            v-on:change="fetchCities($event)"
                            :class="
                              errors && errors.country ? 'border-danger' : ''
                            "
                          >
                            <option selected value="">
                              {{
                                $t(
                                  "mentor.profile.general.place_holder.select_country"
                                )
                              }}
                            </option>
                            <option
                              :value="country.id"
                              v-for="country in countries"
                              :key="country.id"
                            >
                              {{ country.name }}
                            </option>
                          </select>
                          <p
                            v-if="errors && errors.country"
                            class="text-danger position-absolute small"
                          >
                            {{ errors.country[0] }}
                          </p>
                        </div>
                      </div>
                      <div class="col-md-6 position-relative">
                        <label for="" class="text-primary mb-2 mt-4">
                          {{ $t("mentor.profile.general.place_holder.city") }}
                        </label>
                        <div class="custom-select">
                          <select
                            class="form-select border"
                            aria-label="Default select example"
                            v-model="profile.city"
                            :class="
                              errors && errors.city ? 'border-danger' : ''
                            "
                          >
                            <option selected value="">
                              {{
                                $t(
                                  "mentor.profile.general.place_holder.Select_city"
                                )
                              }}
                            </option>
                            <option
                              :value="city.name"
                              v-for="city in cities"
                              :key="city.id"
                            >
                              {{ city.name }}
                            </option>
                            >
                          </select>
                          <p
                            v-if="errors && errors.city"
                            class="text-danger position-absolute small"
                          >
                            {{ errors.city[0] }}
                          </p>
                        </div>
                      </div>
                      <div class="col-md-6 position-relative">
                        <label for="" class="text-primary mb-2 mt-4">
                          {{
                            $t("mentor.profile.general.place_holder.address")
                          }}
                        </label>
                        <vue-google-autocomplete
                          id="map"
                          classname="form-control border"
                          placeholder="Address"
                          v-on:placechanged="getAddressData"
                          v-model="profile.address"
                          :class="
                            errors && errors.address ? 'border-danger' : ''
                          "
                        >
                        </vue-google-autocomplete>
                        <p
                          v-if="errors && errors.address"
                          class="text-danger position-absolute small"
                        >
                          {{ errors.address[0] }}
                        </p>
                      </div>
                      <div class="col-md-6 position-relative">
                        <label for="" class="text-primary mb-2 mt-4">
                          {{
                            $t("mentor.profile.general.place_holder.occupation")
                          }}
                        </label>
                        <div class="custom-select">
                          <select
                            class="form-select border"
                            aria-label="Default select example"
                            v-model="profile.occupation"
                            :class="
                              errors && errors.occupation ? 'border-danger' : ''
                            "
                          >
                            <option selected value="">Select Occupation</option>
                            <option
                              :value="occupation.id"
                              v-for="occupation in occupations"
                              :key="occupation.id"
                            >
                              {{ occupation.name }}
                            </option>
                          </select>
                          <p
                            v-if="errors && errors.occupation"
                            class="text-danger position-absolute small"
                          >
                            {{ errors.occupation[0] }}
                          </p>
                        </div>
                      </div>
                      <div class="col-md-6 position-relative">
                        <label for="" class="text-primary mb-2 mt-4">
                          {{
                            $t(
                              "mentor.profile.general.place_holder.select_religion"
                            )
                          }}
                        </label>
                        <div class="custom-select">
                          <select
                            class="form-select border"
                            aria-label="Default select example"
                            v-model="profile.religion"
                            :class="
                              errors && errors.religion ? 'border-danger' : ''
                            "
                          >
                            <option selected value="">Select Religion</option>
                            <option value="islam">Islam</option>
                            <option value="christian">Christian</option>
                            <option value="hindu">Hindu</option>
                            <option value="sikh">Sikh</option>
                            <option value="jew">Jew</option>
                            <option value="buddhist">Buddhist</option>
                            <option value="other">Others</option>
                          </select>
                          <p
                            v-if="errors && errors.religion"
                            class="text-danger position-absolute small"
                          >
                            {{ errors.religion[0] }}
                          </p>
                        </div>
                      </div>
                      <div class="col-md-12 position-relative">
                        <label for="" class="text-primary mb-2 mt-4">
                          {{
                            $t(
                              "mentor.profile.general.place_holder.about_yourself"
                            )
                          }}
                        </label>
                        <textarea
                          v-model="profile.about"
                          class="form-control border p-2 px-3"
                          rows="5"
                          placeholder="About Yourself"
                          :class="errors && errors.about ? 'border-danger' : ''"
                        ></textarea>
                        <p
                          v-if="errors && errors.about"
                          class="text-danger position-absolute small"
                        >
                          {{ errors.about[0] }}
                        </p>
                      </div>
                    </div>

                    <div class="d-flex justify-content-end mt-5">
                      <button
                        class="btn btn-secondary px-4 text-white"
                        type="submit"
                      >
                        <!-- Continue -->
                        {{ $t("mentor.profile.general.btn_continue") }}
                        <i class="fa-solid fa-angles-right ms-1"></i>
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <!-- educational info  -->
            <div
              class="tab-pane fade"
              id="pills-educational"
              role="tabpanel"
              aria-labelledby="pills-educational-tab"
            >
              <div class="row mb-4">
                <div class="col-md-6 d-flex align-items-center">
                  <h5 class="text-primary">
                    Add your Educational Information Certificate here
                  </h5>
                </div>
                <div
                  class="col-md-6 d-flex align-items-center justify-content-end"
                >
                  <!-- Button trigger modal -->
                  <button
                    type="button"
                    class="btn btn-secondary text-white"
                    data-bs-toggle="modal"
                    data-bs-target="#educationModal"
                  >
                    + Add Education
                  </button>

                  <!-- Modal -->
                  <div
                    class="modal fade"
                    id="educationModal"
                    tabindex="-1"
                    aria-labelledby="educationModalLabel"
                    aria-hidden="true"
                  >
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                      <div class="modal-content border-0">
                        <div class="modal-body py-5">
                          <h3
                            class="
                              modal-title
                              text-primary
                              px-md-4
                              fw-bold
                              mb-4
                            "
                            id="educationModalLabel"
                          >
                            Educational Information Certificate
                          </h3>
                          <form
                            @submit="submitEducationForm"
                            enctype="multipart/form-data"
                            class="px-md-4 mt-md-0 mt-5"
                          >
                            <div class="row">
                              <div class="col-md-6 position-relative">
                                <label for="" class="text-primary mb-2">{{
                                  $t(
                                    "mentor.profile.education.place_holder.Select_degree"
                                  )
                                }}</label>
                                <div class="custom-select">
                                  <select
                                    class="form-select border"
                                    aria-label="Default select example"
                                    v-model="education.degree"
                                    :class="
                                      errors && errors.degree
                                        ? 'border-danger'
                                        : ''
                                    "
                                  >
                                    <option value="">
                                      {{
                                        $t(
                                          "mentor.profile.education.place_holder.Select_degree"
                                        )
                                      }}
                                    </option>
                                    <option
                                      :value="degree.name"
                                      v-for="degree in degrees"
                                      :key="degree.id"
                                    >
                                      {{ degree.name }}
                                    </option>
                                  </select>
                                  <p
                                    v-if="errors && errors.degree"
                                    class="text-danger position-absolute small"
                                  >
                                    {{ errors.degree[0] }}
                                  </p>
                                </div>
                              </div>
                              <div class="col-md-6 position-relative">
                                <label for="" class="text-primary mb-2">{{
                                  $t(
                                    "mentor.profile.education.place_holder.subject"
                                  )
                                }}</label>
                                <input
                                  type="text"
                                  v-model="education.subject"
                                  :placeholder="
                                    $t(
                                      'mentor.profile.education.place_holder.subject'
                                    )
                                  "
                                  class="form-control border"
                                  :class="
                                    errors && errors.subject
                                      ? 'border-danger'
                                      : ''
                                  "
                                />
                                <p
                                  v-if="errors && errors.subject"
                                  class="text-danger position-absolute small"
                                >
                                  {{ errors.subject[0] }}
                                </p>
                              </div>
                              <div class="col-md-6 position-relative">
                                <label for="" class="text-primary mb-2 mt-4">
                                  {{
                                    $t(
                                      "mentor.profile.education.place_holder.institution"
                                    )
                                  }}
                                </label>
                                <input
                                  type="text"
                                  v-model="education.institute"
                                  :placeholder="
                                    $t(
                                      'mentor.profile.education.place_holder.institution'
                                    )
                                  "
                                  class="form-control border"
                                  :class="
                                    errors && errors.institute
                                      ? 'border-danger'
                                      : ''
                                  "
                                />
                                <p
                                  v-if="errors && errors.institute"
                                  class="text-danger position-absolute small"
                                >
                                  {{ errors.institute[0] }}
                                </p>
                              </div>

                              <div class="col-md-6 position-relative">
                                <label for="" class="text-primary mb-2 mt-4">{{
                                  $t(
                                    "mentor.profile.education.place_holder.year"
                                  )
                                }}</label>
                                <datetime
                                  type="date"
                                  :flow="['year']"
                                  max-datetime="2022"
                                  :format="'yyyy'"
                                  :placeholder="
                                    $t(
                                      'mentor.profile.education.place_holder.year'
                                    )
                                  "
                                  v-model="education.period"
                                  :input-class="
                                    errors && errors.period
                                      ? 'border-danger form-control border'
                                      : 'form-control border'
                                  "
                                ></datetime>
                                <p
                                  v-if="errors && errors.period"
                                  class="text-danger position-absolute small"
                                >
                                  {{ errors.period[0] }}
                                </p>
                              </div>

                              <div class="col-md-12 position-relative">
                                <label for="" class="text-primary mb-2 mt-4">
                                  Upload Certificate</label
                                >

                                <div
                                  class="
                                    upload-btn-wrapper
                                    d-flex
                                    w-100
                                    border
                                    p-1
                                  "
                                >
                                  <button
                                    class="
                                      h-100
                                      me-3
                                      btn btn-upload
                                      d-flex
                                      justify-content-center
                                      border-0
                                      bg-muted
                                      text-dark
                                      py-2
                                      px-3
                                    "
                                    style="padding: 12px"
                                  >
                                    <img
                                      :src="url + '/assets/images/upload.png'"
                                      class="upload"
                                      alt=""
                                    />
                                  </button>
                                  <input
                                    type="file"
                                    id="image_education"
                                    ref="image_education"
                                    @change="processEducationFile($event)"
                                  />
                                  <img
                                    :src="education.image_view"
                                    @click="previewEducationImage"
                                    width="40px"
                                    height="40px"
                                    v-if="education.image_view"
                                  />
                                </div>

                                <p
                                  v-if="errors && errors.image"
                                  class="text-danger position-absolute small"
                                >
                                  {{ errors.image[0] }}
                                </p>
                              </div>

                              <div
                                class="
                                  col-md-12
                                  d-flex
                                  align-items-end
                                  justify-content-end
                                "
                              >
                                <div class="mt-4">
                                  <button
                                    class="
                                      btn btn-upload
                                      d-flex
                                      align-items-end
                                      justify-content-center
                                      border-0
                                      btn-secondary
                                      box-shadow-secondary
                                      text-white
                                      px-4
                                    "
                                    type="submit"
                                  >
                                    Add
                                  </button>
                                  <!-- <input type="file" /> -->
                                </div>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="table-responsive">
                <table class="table table-striped align-middle">
                  <tr class="text-primary light-bg">
                    <th class="py-3">
                      {{ $t("mentor.profile.education.table.degree") }}
                    </th>
                    <th class="py-3">
                      {{ $t("mentor.profile.education.table.subject") }}
                    </th>
                    <th class="py-3">
                      {{ $t("mentor.profile.education.table.institution") }}
                    </th>
                    <th class="py-3">
                      {{ $t("mentor.profile.education.table.Year") }}
                    </th>
                    <th class="py-3">Image</th>
                    <th class="py-3">Action</th>
                  </tr>
                  <tr
                    v-for="(education, index) in allEducations"
                    :key="education.id"
                  >
                    <td>{{ education.degree }}</td>
                    <td>{{ education.subject }}</td>
                    <td>{{ education.institute }}</td>
                    <td>{{ education.period }}</td>
                    <td>
                      <img
                        style="height: 50px; width: 50px"
                        :src="education.image_path"
                        alt=""
                      />
                    </td>
                    <td>
                      <a
                        href="javascript:void(0)"
                        @click="deleteMentorEducation(education.id, index)"
                        ><i class="fas fa-trash text-secondary"></i>
                      </a>
                    </td>
                  </tr>

                  <tr v-if="allEducations.length == 0">
                    <td colspan="6" class="text-center">No record found</td>
                  </tr>
                </table>
              </div>
              <div class="d-flex justify-content-end mt-150">
                <button
                  class="btn btn-dark px-4 text-white me-3"
                  @click="BackGeneralTab"
                  type="button"
                >
                  <i class="fa-solid fa-angles-left me-1"></i>
                  <!-- Back -->
                  {{ $t("mentor.profile.general.btn_back") }}
                </button>

                <button
                  class="btn btn-secondary px-4 text-white"
                  @click="continueExperienceTab"
                  type="button"
                >
                  <!-- Continue -->
                  {{ $t("mentor.profile.general.btn_continue") }}
                  <i class="fa-solid fa-angles-right ms-1"></i>
                </button>
              </div>
            </div>
            <!-- Experience Info -->
            <div
              class="tab-pane fade"
              id="pills-experience"
              role="tabpanel"
              aria-labelledby="pills-experience-tab"
            >
              <div class="row mb-4">
                <div class="col-md-6 d-flex align-items-center">
                  <h5 class="text-primary">
                    Add your Experience Information Certificate here
                  </h5>
                </div>
                <div
                  class="col-md-6 d-flex align-items-center justify-content-end"
                >
                  <!-- Button trigger modal -->
                  <button
                    type="button"
                    class="btn btn-secondary text-white"
                    data-bs-toggle="modal"
                    data-bs-target="#experienceModal"
                  >
                    + Add Experience
                  </button>

                  <!-- Modal -->
                  <div
                    class="modal fade"
                    id="experienceModal"
                    tabindex="-1"
                    aria-labelledby="experienceModalLabel"
                    aria-hidden="true"
                  >
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                      <div class="modal-content border-0">
                        <div class="modal-body py-5">
                          <h3
                            class="
                              modal-title
                              text-primary
                              px-md-4
                              fw-bold
                              mb-4
                            "
                            id="experienceModalLabel"
                          >
                            Experience Information Certificate
                          </h3>
                          <form
                            @submit="submitExperienceForm"
                            enctype="multipart/form-data"
                            class="px-md-4 mt-md-0 mt-5"
                          >
                            <div class="row">
                              <div class="col-md-6 position-relative">
                                <label for="" class="text-primary mb-2 mt-4">{{
                                  $t(
                                    "mentor.profile.experience.place_holder.company_name"
                                  )
                                }}</label>
                                <input
                                  type="text"
                                  :placeholder="
                                    $t(
                                      'mentor.profile.experience.place_holder.company_name'
                                    )
                                  "
                                  class="form-control border"
                                  v-model="experience.company_name"
                                  :class="
                                    errors && errors.company
                                      ? 'border-danger'
                                      : ''
                                  "
                                />
                                <p
                                  v-if="errors && errors.company"
                                  class="text-danger position-absolute small"
                                >
                                  {{ errors.company[0] }}
                                </p>
                              </div>
                              <div class="col-md-3 position-relative">
                                <label for="" class="text-primary mb-2 mt-4">{{
                                  $t(
                                    "mentor.profile.experience.place_holder.from"
                                  )
                                }}</label>
                                <datetime
                                  type="date"
                                  :max-datetime="minDatetime"
                                  :placeholder="
                                    $t(
                                      'mentor.profile.experience.place_holder.from'
                                    )
                                  "
                                  v-model="experience.date_from"
                                  :input-class="
                                    errors && errors.from
                                      ? 'border-danger form-control border'
                                      : 'form-control border'
                                  "
                                ></datetime>
                                <p
                                  v-if="errors && errors.from"
                                  class="text-danger position-absolute small"
                                >
                                  {{ errors.from[0] }}
                                </p>
                              </div>
                              <div class="col-md-3 position-relative">
                                <label for="" class="text-primary mb-2 mt-4">{{
                                  $t(
                                    "mentor.profile.experience.place_holder.to"
                                  )
                                }}</label>
                                <datetime
                                  type="date"
                                  :max-datetime="minDatetime"
                                  :placeholder="
                                    $t(
                                      'mentor.profile.experience.place_holder.to'
                                    )
                                  "
                                  v-model="experience.date_to"
                                  :input-class="
                                    errors && errors.to
                                      ? 'border-danger form-control border'
                                      : 'form-control border'
                                  "
                                ></datetime>
                                <p
                                  v-if="errors && errors.to"
                                  class="text-danger position-absolute small"
                                >
                                  {{ errors.to[0] }}
                                </p>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-12">
                                <label for="" class="text-primary mb-2 mt-4">
                                  Upload Certificate</label
                                >

                                <div
                                  class="
                                    upload-btn-wrapper
                                    d-flex
                                    w-100
                                    border
                                    p-1
                                  "
                                >
                                  <button
                                    class="
                                      h-100
                                      me-3
                                      btn btn-upload
                                      d-flex
                                      justify-content-center
                                      border-0
                                      bg-muted
                                      text-dark
                                      py-2
                                      px-3
                                    "
                                    style="padding: 12px"
                                  >
                                    <img
                                      :src="url + '/assets/images/upload.png'"
                                      class="upload"
                                      alt=""
                                    />
                                  </button>
                                  <input
                                    type="file"
                                    id="experience_image"
                                    ref="experience_image"
                                    @change="processExperienceFile($event)"
                                    name="experience_image"
                                  />
                                  <img
                                    :src="experience.image_view"
                                    @click="previewExperienceImage"
                                    width="40px"
                                    height="40px"
                                    v-if="experience.image_view"
                                  />
                                </div>
                                <p
                                  v-if="errors && errors.image"
                                  class="text-danger position-absolute small"
                                >
                                  {{ errors.image[0] }}
                                </p>
                              </div>
                              <div
                                class="
                                  col-md-12
                                  d-flex
                                  align-items-end
                                  justify-content-end
                                "
                              >
                                <div class="mt-4">
                                  <button
                                    class="
                                      btn btn-upload
                                      d-flex
                                      align-items-end
                                      justify-content-center
                                      border-0
                                      btn-secondary
                                      box-shadow-secondary
                                      text-white
                                      px-4
                                    "
                                    type="submit"
                                  >
                                    Add
                                  </button>
                                  <!-- <input type="file" /> -->
                                </div>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="table-responsive">
                <table class="table table-striped align-middle">
                  <tr class="text-primary light-bg">
                    <th class="py-3">
                      {{ $t("mentor.profile.experience.table.company") }}
                    </th>
                    <th class="py-3">
                      {{ $t("mentor.profile.experience.table.period_from") }}
                    </th>
                    <th class="py-3">
                      {{ $t("mentor.profile.experience.table.period_to") }}
                    </th>

                    <th class="py-3">Image</th>
                    <th class="py-3">Action</th>
                  </tr>
                  <tr
                    v-for="(experience, index) in allExperiences"
                    :key="experience.id"
                  >
                    <td>{{ experience.company }}</td>
                    <td>{{ experience.company }}</td>
                    <td>{{ experience.company }}}</td>
                    <td>
                      <img
                        style="height: 50px; width: 50px"
                        :src="experience.image_path"
                        alt=""
                      />
                    </td>
                    <td>
                      <a
                        href="javascript:void(0)"
                        @click="deleteMentorExperiences(experience.id, index)"
                        ><i class="fas fa-trash text-secondary"></i>
                      </a>
                    </td>
                  </tr>
                  <tr v-if="allExperiences.length == 0">
                    <td colspan="5" class="text-center">No record found</td>
                  </tr>
                </table>
              </div>

              <div class="d-flex justify-content-end mt-150">
                <button
                  class="btn btn-dark px-4 text-white me-3"
                  @click="backEducationTab"
                  type="button"
                >
                  <i class="fa-solid fa-angles-left me-1"></i>
                  {{ $t("mentor.profile.general.btn_back") }}
                </button>

                <button
                  class="btn btn-secondary px-4 text-white"
                  @click="ContinueSkillTab"
                  type="button"
                >
                  {{ $t("mentor.profile.general.btn_continue") }}
                  <i class="fa-solid fa-angles-right ms-1"></i>
                </button>
              </div>
            </div>

            <!-- skills info -->
            <div
              class="tab-pane fade"
              id="pills-skills"
              role="tabpanel"
              aria-labelledby="pills-skills-tab"
            >
              <div class="row mb-4">
                <div class="col-md-6 d-flex align-items-center">
                  <h5 class="text-primary">
                    Add your Professional Skills here
                  </h5>
                </div>
                <div
                  class="col-md-6 d-flex align-items-center justify-content-end"
                >
                  <!-- Button trigger modal -->
                  <button
                    type="button"
                    class="btn btn-secondary text-white"
                    data-bs-toggle="modal"
                    data-bs-target="#skillsModal"
                  >
                    + Add Skills
                  </button>

                  <!-- Modal -->
                  <div
                    class="modal fade"
                    id="skillsModal"
                    tabindex="-1"
                    aria-labelledby="skillsModalLabel"
                    aria-hidden="true"
                  >
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                      <div class="modal-content border-0">
                        <div class="modal-body py-5">
                          <h3
                            class="
                              modal-title
                              text-primary
                              px-md-4
                              fw-bold
                              mb-4
                            "
                            id="skillsModalLabel"
                          >
                            Profressional Skills
                          </h3>

                          <form class="px-md-4 mt-md-0 mt-5">
                            <div class="row">
                              <div
                                class="col-lg-6 mt-2"
                                v-for="(category, index) in allCategories"
                                :key="index"
                              >
                                <label for="" class="text-primary mb-2">{{
                                  $t("mentor.profile.skill.select_categories")
                                }}</label>
                                <div class="custom-select mb-2">
                                  <select
                                    class="form-select border"
                                    aria-label="Default select example"
                                    v-model="selectedCategories[0]"
                                    v-on:change="
                                      fetchSubcategories($event, index)
                                    "
                                  >
                                    <option
                                      :value="item.id"
                                      v-for="item in category.items"
                                      :key="item.id"
                                    >
                                      <p v-if="item.name">
                                        {{ item.name }}
                                      </p>
                                    </option>
                                  </select>
                                  <p
                                    v-if="errors && errors.categories"
                                    class="text-danger small position-absolute"
                                  >
                                    {{ errors.categories[0] }}
                                  </p>
                                </div>
                                <div class="row">
                                      <div
                                class="
                                  col-md-6

                                "
                              >
                                <div class="mt-3">
                                  <button
                                    class="
                                      btn btn-upload
                                      w-100
                                      border-0
                                      btn-secondary
                                      box-shadow-secondary
                                      text-white
                                      px-4
                                    "
                                    v-on:click="addSkill"
                                    type="button"
                                    style="padding: 12px"
                                  >
                                    Add
                                  </button>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="text-end mt-3 mb-lg-0 mb-4">
                                  <button
                                    v-on:click="resetSkills"
                                    type="button"
                                    class="btn-danger btn btn-lg w-100"
                                  >
                                    {{ $t("mentor.profile.skill.reset_label") }}
                                  </button>
                                </div>
                              </div>
                                </div>
                              </div>
                              <!-- Sub Category Tree... -->
                              <div
                                class="col-lg-6 mt-2 adjust-field cat-select-tree"
                                v-if="categoriesFilteroptions.length > 0"
                              >
                                <label for="" class="text-primary mb-2">{{
                                  $t("mentor.profile.skill.select_categories")
                                }}</label>
                                <treeselect
                                  v-model="selectedSubCategories"
                                  :multiple="true"
                                  value-consists-of="ALL_WITH_INDETERMINATE"
                                  :options="categoriesFilteroptions"
                                  class="border-r"
                                />
                              </div>

                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="table-responsive">
                <table class="table table-striped align-middle">
                  <tr class="text-primary light-bg">
                    <th class="py-3">
                      {{ $t("mentor.profile.skill.categories") }}
                    </th>
                  </tr>
                  <tr v-for="category in skills.categories" :key="category.id">
                    <td>{{ category.name }}</td>
                  </tr>
                </table>
              </div>

              <div class="d-flex justify-content-end mt-150">
                <button
                  class="btn btn-dark px-4 text-white me-3"
                  @click="continueExperienceTab"
                  type="button"
                >
                  <i class="fa-solid fa-angles-left me-1"></i>
                  <!-- Back -->
                  {{ $t("mentor.profile.general.btn_back") }}
                </button>

                <button
                  class="btn btn-secondary px-4 text-white"
                  @click="continueBankTab"
                  type="button"
                >
                  <!-- Continue -->
                  {{ $t("mentor.profile.general.btn_continue") }}
                  <i class="fa-solid fa-angles-right ms-1"></i>
                </button>
              </div>
            </div>

            <!-- account info -->
            <div
              class="tab-pane fade"
              id="pills-acc"
              role="tabpanel"
              aria-labelledby="pills-acc-tab"
            >
              <div class="row">
                <div class="col-md-12">
                  <form action="" class="px-md-4 mt-md-0 mt-5">
                    <div class="row">
                      <div class="col-md-6 position-relative">
                        <label for="" class="text-primary mb-2">
                          {{
                            $t(
                              "mentor.profile.account_information.select_bank_name"
                            )
                          }}</label
                        >
                        <div class="custom-select">
                          <select
                            class="form-select border"
                            aria-label="Default select example"
                            v-model="bank.name"
                            :class="
                              errors && errors.bank ? 'border-danger' : ''
                            "
                          >
                            <option value="" selected>
                              {{
                                $t(
                                  "mentor.profile.account_information.select_bank_name"
                                )
                              }}
                            </option>
                            <option
                              v-for="bank in allBanks"
                              :key="bank.id"
                              :value="bank.name"
                            >
                              {{ bank.name }}
                            </option>
                          </select>
                          <p
                            v-if="errors && errors.bank"
                            class="text-danger small position-absolute"
                          >
                            {{ errors.bank[0] }}
                          </p>
                        </div>
                      </div>

                      <div class="col-md-3 position-relative">
                        <label for="" class="text-primary mb-2">{{
                          $t(
                            "mentor.profile.account_information.account_holder_name"
                          )
                        }}</label>
                        <input
                          type="text"
                          class="form-control border"
                          v-model="bank.account_title"
                          :placeholder="
                            $t(
                              'mentor.profile.account_information.account_holder_name'
                            )
                          "
                          :class="
                            errors && errors.account_title
                              ? 'border-danger'
                              : ''
                          "
                        />
                        <p
                          v-if="errors && errors.account_title"
                          class="text-danger small position-absolute"
                        >
                          {{ errors.account_title[0] }}
                        </p>
                      </div>

                      <div class="col-md-3 position-relative">
                        <label for="" class="text-primary mb-2">
                          {{
                            $t(
                              "mentor.profile.account_information.account_number"
                            )
                          }}</label
                        >
                        <input
                          type="number"
                          class="form-control border"
                          :placeholder="
                            $t(
                              'mentor.profile.account_information.account_number'
                            )
                          "
                          v-model="bank.account_number"
                          :class="
                            errors && errors.account_number
                              ? 'border-danger'
                              : ''
                          "
                        />
                        <p
                          v-if="errors && errors.account_number"
                          class="text-danger small position-absolute"
                        >
                          {{ errors.account_number[0] }}
                        </p>
                      </div>
                      <div
                        class="
                          col-md-12
                          d-flex
                          align-items-end
                          justify-content-end
                        "
                      >
                        <div class="mt-5">
                          <button
                            class="
                              btn btn-upload
                              d-flex
                              align-items-end
                              justify-content-center
                              border-0
                              btn-secondary
                              box-shadow-secondary
                              text-white
                              px-4
                            "
                            v-on:click="addBankDetail"
                            type="button"
                            style="padding: 12px"
                          >
                            Add
                          </button>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
              <div class="d-flex justify-content-end mt-150">
                <button
                  class="btn btn-dark px-4 text-white me-3"
                  @click="backSkillTab"
                  type="button"
                >
                  <i class="fa-solid fa-angles-left me-1"></i>
                  <!-- Back -->
                  {{ $t("mentor.profile.general.btn_back") }}
                </button>

                <button
                  class="btn btn-secondary px-4 text-white"
                  @click="continueDashboard"
                  type="button"
                >
                  <!-- Finish -->
                  {{ $t("mentor.profile.general.btn_finish") }}

                  <i class="fa-solid fa-angles-right ms-1"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
<script>
import loginMixin from "../mixins/loginMixin.js";
import VueGoogleAutocomplete from "vue-google-autocomplete";
import Treeselect from "@riophae/vue-treeselect";
import "@riophae/vue-treeselect/dist/vue-treeselect.css";
export default {
  props: ["url"],
  mixins: [loginMixin],
  components: { VueGoogleAutocomplete, Treeselect },

  data() {
    return {
      loading: true,
      show_status: "",
      errors: {},
      profile: {
        first_name: "",
        last_name: "",
        email: "",
        address: "",
        f_name: "",
        cnic: "",
        gender: "",
        religion: "",
        dob: "",
        occupation: "",
        country: "",
        city: "",
        picture: {},
        image_view: "",
        image_path: "",
        token: 123,
        online_status: true,
        go_live_status: false,
        image_loading: false,
        about: "",
      },
      countries: {},
      cities: {},
      occupations: {},
      education: {
        degree: "",
        institute: "",
        subject: "",
        period: "",
        image: {},
        token: 123,
        image_view: "",
      },
      experience: {
        company_name: "",
        date_from: "",
        date_to: "",
        experience_image: {},
        image_view: "",
        token: 123,
      },
      allExperiences: [],
      degrees: {},
      allEducations: [],
      allCategories: [],
      categoriesLoading: false,
      categoriesFilteroptions: [],
      selectedSubCategories: null,
      skills: {
        categories: "",
      },
      allBanks: {},
      bank: {
        name: "",
        account_title: "",
        account_number: "",
        id: "",
      },
      minDatetime: new Date().toLocaleDateString("en-US", {
        year: "numeric",
        month: "numeric",
      }),
    };
  },
  methods: {
    deleteExperienceImage() {
      this.experience.image_view = "";
    },
    previewExperienceImage() {
      window.open(this.experience.image_view, "_blank").focus();
    },
    previewEducationImage() {
      window.open(this.education.image_view, "_blank").focus();
    },
    removeEducationImage() {
      this.education.image_view = "";
    },
    previewImage() {
      window.open(this.profile.image_view, "_blank").focus();
    },
    removeImage() {
      this.profile.image_view = "";
    },
    async onStatusChangeEventHandler() {
      var self = this;
      var toast = this.$toasted;
      if (this.profile.online_status) {
        localStorage.setItem("show_online", 1);
        var params = {
          token: 123,
          status: "online",
          user_id: this.User.user_id,
        };
      } else {
        localStorage.removeItem("show_online");
        var params = {
          token: 123,
          status: "offline",
          user_id: this.User.user_id,
        };
      }
      const res = await axios
        .post("/api/changeOnlineStatus", params)
        .then((res) => {
          if (res.data.Status) {
            toast.success(res.data.msg);
            this.show_status = params.status;
          }
          if (!res.data.Status) {
            // toast.error(res.data.msg);
            this.errors = res.data.errors;
          }
        });
    },
    backSkillTab() {
      document.getElementById("pills-skills-tab").click();
    },
    continueExperienceTab() {
      document.getElementById("pills-experience-tab").click();
    },
    continueDashboard() {
      window.location.href = "/dashboard";
    },
    backEducationTab() {
      document.getElementById("pills-educational-tab").click();
    },
    continueBankTab() {
      document.getElementById("pills-acc-tab").click();
    },
    ContinueSkillTab() {
      document.getElementById("pills-skills-tab").click();
    },
    BackGeneralTab() {
      document.getElementById("pills-general-tab").click();
    },
    async updateProfileCompleteStatus() {
      var params = {
        token: 123,
        mentor_id: this.User.user_id,
      };
      const res = await axios
        .post("/api/mentorProfile", params)
        .then((res) => {});
      if (this.is_profile_completed == 0) {
        window.location.href = "/dashboard";
      }
    },
    async addBankDetail() {
      var self = this;
      var toast = this.$toasted;
      if (this.bank.id) {
        var formData = {
          token: 123,
          mentor_id: this.User.user_id,
          bank: this.bank.name,
          account_title: this.bank.account_title,
          account_number: this.bank.account_number,

          id: this.bank.id,
        };
        const res = await axios
          .post("/api/mentor_card_update", formData)
          .then((res) => {
            if (res.data.Status) {
              toast.success(res.data.msg);
              self.updateProfileCompleteStatus();
            }
            if (!res.data.Status) {
              //   toast.error("Please Fill all Fields...");
              this.errors = res.data.errors;
            }
          });
      } else {
        var formData = {
          token: 123,
          mentor_id: this.User.user_id,
          account_title: this.bank.account_title,
          account_number: this.bank.account_number,
          bank: this.bank.name,
        };
        const res = await axios
          .post("/api/mentor_card", formData)
          .then((res) => {
            if (res.data.Status) {
              toast.success(res.data.msg);
              this.bank.id = res.data.data.card.id;
              self.updateProfileCompleteStatus();
            }
            if (!res.data.Status) {
              // toast.error("Please Fill all Fields...");
              this.errors = res.data.errors;
            }
          });
      }
    },
    async fetchBankTabData() {
      const result = await axios.get("/api/bankslist", {
        params: { token: 123 },
      });
      if (result.data && result.data.Status) {
        this.allBanks = result.data.data.banks;
      }
      const params = {
        token: 123,
        mentor_id: this.User.user_id,
      };
      const res = await axios.get("/api/mentor_card_show", { params });
      if (res.data && res.data.Status) {
        if (res.data.data.card) {
          this.bank.name = res.data.data.card.bank;
          this.bank.account_title = res.data.data.card.account_title;
          this.bank.account_number = res.data.data.card.account_number;
          this.bank.id = res.data.data.card.id;
        }
      }
    },
    async fetchSubcategories(event, index) {
      this.categoriesLoading = true;
      this.categoriesFilteroptions = [];
      this.selectedSubCategories = null;
      var parent_id = event.target.value;
      const params = {
        token: 123,
        parent_id: parent_id,
      };
      const res = await axios.get("/api/mentorChildCategoriesList", { params });
      if (res.data && res.data.Status) {
        this.mentorSubCategory = res.data.data.mentorCategories;
        if (this.mentorSubCategory.length > 0) {
          this.categoriesFilteroptions = this.makeChildrens(
            this.mentorSubCategory
          );
        }
        this.categoriesLoading = false;
        return;
        // let tempCatArray = [];
        // let tempSelectedCatArray = [];
        // for (let i = 0; i <= index; i++) {
        //   tempCatArray.push(this.allCategories[i]);
        //   tempSelectedCatArray.push(this.selectedCategories[i]);
        // }
        // this.allCategories = tempCatArray;
        // this.selectedCategories = tempSelectedCatArray;
        // if (this.mentorSubCategory.length > 0) {
        //   var obj = {
        //     id: index++,
        //     items: this.mentorSubCategory,
        //   };
        //   this.allCategories.push(obj);
        //   this.selectedCategories.push(index);
        // }
        // this.categoriesLoading = false;
      }
    },
    async fetchAllSkills() {
      this.categoriesLoading = true;
      const params = {
        token: 123,
        mentor_id: this.User.user_id,
      };
      const res = await axios.get("/api/mentorSkillSelected", { params });
      if (res.data && res.data.Status) {
        this.skills.categories = res.data.data.category;
        this.selectedCategories.push(res.data.data.category[0].id);
        if (this.selectedCategories.length > 0) {
          this.categoriesLoading = true;
          this.categoriesFilteroptions = [];
          this.selectedSubCategories = null;
          var parent_id = this.selectedCategories[0];
          const params = {
            token: 123,
            parent_id: parent_id,
          };
          const response = await axios.get("/api/mentorChildCategoriesList", {
            params,
          });
          if (response.data && response.data.Status) {
            this.mentorSubCategory = response.data.data.mentorCategories;
            if (this.mentorSubCategory.length > 0) {
              this.categoriesFilteroptions = this.makeChildrens(
                this.mentorSubCategory
              );
            }
            this.selectedSubCategories = [];
            res.data.data.category.forEach((element, index) => {
              if (index != 0) {
                this.selectedSubCategories.push(element.id);
              }
            });
            this.categoriesLoading = false;
          }
        }
      }
      this.categoriesLoading = false;
    },

    async addSkill() {
      var self = this;
      var toast = this.$toasted;
      if (this.selectedSubCategories) {
        let mainCategory = this.selectedCategories[0];
          this.selectedCategories = [];
          this.selectedCategories.push(mainCategory);
        this.selectedSubCategories.forEach((element) => {
          this.selectedCategories.push(element);
        });
      }
      var formData = {
        token: 123,
        mentor_id: this.User.user_id,
        categories: this.selectedCategories,
      };
      const res = await axios.post("/api/mentorSkill", formData).then((res) => {
        if (res.data.Status) {
          toast.success(res.data.msg);
          $(".modal").modal("hide");
          $("body").removeClass("modal-open");
          $(".modal-backdrop").remove();
          self.fetchAllSkills();
        }
        if (!res.data.Status) {
          this.errors = res.data.errors;
        }
      });
    },
    async fetchSkillsTabData() {
      this.allCategories = [];
      this.selectedCategories = [];
      const params = {
        token: 123,
      };
      const res = await axios.get("/api/mentorCategoriesList", {
        params,
      });
      if (res.data && res.data.Status) {
        this.mentorCategories = res.data.data.mentorCategories;

        var obj = {
          id: 0,
          items: this.mentorCategories,
        };
        this.allCategories.push(obj);
        this.fetchAllSkills();
      }
    },
    async fetchAllExperiences() {
      const params = {
        token: 123,
        mentor_id: this.User.user_id,
      };
      const res = await axios.get("/api/mentorExperienceList", {
        params,
      });
      if (res.data && res.data.Status) {
        this.allExperiences = res.data.data.experiences;
      }
    },
    accTab() {
      $("#pills-educational-tab").addClass("active");
      $("#pills-experience-tab").addClass("active");
      $("#pills-general-tab").addClass("active");
      $("#pills-skills-tab").addClass("active");
      $("#pills-skills").removeClass("show");
      $("#pills-skills").removeClass("active");
      $("#pills-experience-tab").addClass("active");
      $("#pills-acc-tab").addClass("active");
      $("#pills-acc").addClass("show");
      $("#pills-acc").addClass("active");
      $("#pills-schedule-tab").removeClass("active");
      $("#pills-schedule").removeClass("show");
      $("#pills-schedule").removeClass("active");

      this.fetchBankTabData();
    },
    skillsTab() {
      $("#pills-educational-tab").addClass("active");
      $("#pills-general-tab").addClass("active");
      $("#pills-experience-tab").addClass("active");
      $("#pills-experience").removeClass("show");
      $("#pills-experience").removeClass("active");
      $("#pills-skills-tab").addClass("active");
      $("#pills-skills").addClass("show");
      $("#pills-skills").addClass("active");
      $("#pills-experience-tab").addClass("active");
      $("#pills-schedule-tab").removeClass("active");
      $("#pills-schedule").removeClass("show");
      $("#pills-schedule").removeClass("active");
      $("#pills-acc-tab").removeClass("active");
      $("#pills-acc").removeClass("show");
      $("#pills-acc").removeClass("active");
      this.fetchSkillsTabData();
    },

    async fetchDegrees() {
      const params = {
        token: 123,
      };
      const res = await axios.get("/api/degreeList", {
        params,
      });
      if (res.data && res.data.Status) {
        this.degrees = res.data.data.mentorDegrees;
      }
    },
    async fetchAllEducations() {
      const params = {
        token: 123,
        mentor_id: this.User.user_id,
      };
      const res = await axios.get("/api/mentorEducationList", { params });
      if (res.data && res.data.Status) {
        this.allEducations = res.data.data.educations;
      }
    },
    educationalTab() {
      $("#pills-general-tab").addClass("active");
      $("#pills-educational").addClass("show");
      $("#pills-educational").addClass("active");
      $("#pills-experience-tab").removeClass("active");
      $("#pills-experience").removeClass("active");
      $("#pills-experience").removeClass("show");
      $("#pills-schedule-tab").removeClass("active");
      $("#pills-schedule").removeClass("show");
      $("#pills-schedule").removeClass("active");
      $("#pills-acc-tab").removeClass("active");
      $("#pills-acc").removeClass("show");
      $("#pills-acc").removeClass("active");
      $("#pills-skills-tab").removeClass("active");
      $("#pills-skills").removeClass("show");
      $("#pills-skills").removeClass("active");
      $("#pills-educational").addClass("active");
      $("#pills-educational").addClass("show");
      $("#pills-acc").removeClass("active");
      $("#pills-acc").removeClass("show");
      $("#pills-acc-tab").removeClass("active");
      $("#pills-skills-tab").removeClass("active");
      $("#pills-skills").removeClass("show");
      $("#pills-skills").removeClass("active");
      this.fetchDegrees();
      this.fetchAllEducations();
      this.fetchAllExperiences();
    },
    experienceTab() {
      $("#pills-general-tab").addClass("active");
      $("#pills-educational-tab").addClass("active");
      $("#pills-experience-tab").addClass("active");
      $("#pills-experience").addClass("active");
      $("#pills-experience").addClass("show");
      $("#pills-schedule-tab").removeClass("active");
      $("#pills-schedule").removeClass("show");
      $("#pills-schedule").removeClass("active");
      $("#pills-acc-tab").removeClass("active");
      $("#pills-acc").removeClass("show");
      $("#pills-acc").removeClass("active");
      $("#pills-skills-tab").removeClass("active");
      $("#pills-skills").removeClass("show");
      $("#pills-skills").removeClass("active");
      $("#pills-educational").removeClass("active");
      $("#pills-educational").removeClass("show");
      $("#pills-acc").removeClass("active");
      $("#pills-acc").removeClass("show");
      $("#pills-acc-tab").removeClass("active");
      $("#pills-skills-tab").removeClass("active");
      $("#pills-skills").removeClass("show");
      $("#pills-skills").removeClass("active");
      //   this.fetchDegrees();
      //   this.fetchAllEducations();
      this.fetchAllExperiences();
    },
    generalTab() {
      $("#pills-general").addClass("active");
      $("#pills-general").addClass("show");
      $("#pills-experience-tab").removeClass("active");
      $("#pills-experience").removeClass("active");
      $("#pills-acc").removeClass("active");
      $("#pills-acc").removeClass("show");
      $("#pills-acc-tab").removeClass("active");

      $("#pills-schedule-tab").removeClass("active");
      $("#pills-schedule").removeClass("show");
      $("#pills-schedule").removeClass("active");

      $("#pills-educational-tab").removeClass("active");
      $("#pills-educational").removeClass("show");
      $("#pills-educational").removeClass("active");

      $("#pills-experience-tab").removeClass("active");
      $("#pills-experience").removeClass("show");
      $("#pills-experience").removeClass("active");

      $("#pills-skills-tab").removeClass("active");
      $("#pills-skills").removeClass("show");
      $("#pills-skills").removeClass("active");
    },
    clearImage() {
      this.profile.image_view = "";
    },
    processFile(event) {
      this.profile.picture = event.target.files[0];
      this.profile.image_view = URL.createObjectURL(event.target.files[0]);
    },
    processEducationFile(event) {
      this.education.image = event.target.files[0];
      this.education.image_view = URL.createObjectURL(event.target.files[0]);
    },
    async submitEducationForm(e) {
      var self = this;
      var toast = this.$toasted;
      e.preventDefault();
      const headers = {
        "Content-Type": "multipart/form-data",
      };

      let formData = new FormData();
      formData.append("image", this.education.image);
      formData.append("token", this.education.token);
      formData.append("mentor_id", this.User.user_id);
      formData.append("institute", this.education.institute);
      formData.append("degree", this.education.degree);
      formData.append("subject", this.education.subject);
      formData.append("period", this.education.period);
      const res = await axios
        .post("/api/mentorEducation", formData, {
          headers: headers,
        })
        .then((res) => {
          if (res.data.Status) {
            toast.success(res.data.msg);
            self.allEducations.push(res.data.data.education);
            self.education.degree = "";
            self.education.institute = "";
            self.education.subject = "";
            self.education.period = "";
            self.education.image_view = "";
            $("#image_education").val("");
            $(".modal").modal("hide");
            $("body").removeClass("modal-open");
            // $("body").addClass("overflow-c");
            // $("body").addClass("pe-0");
            $(".modal-backdrop").remove();
          }
          if (!res.data.Status) {
            // toast.error("Please Fill all Fields...");
            this.errors = res.data.errors;
          }
        });
    },
    async deleteMentorEducation(id, index) {
      var self = this;
      var toast = this.$toasted;
      var params = {
        token: 123,
        id: id,
      };
      const res = await axios
        .post("/api/mentorEducationDelete", params)
        .then((res) => {
          if (res.data.Status) {
            toast.success(res.data.msg);
            this.fetchAllEducations();
            // this.allEducations.splice(this.allEducations.indexOf(index), 1);
          }
        });
    },

    async deleteMentorExperiences(id, index) {
      var self = this;
      var toast = this.$toasted;
      var params = {
        token: 123,
        id: id,
      };
      const res = await axios
        .post("/api/mentorExperienceDelete", params)
        .then((res) => {
          if (res.data.Status) {
            toast.success(res.data.msg);
            this.allExperiences.splice(this.allExperiences.indexOf(id), index);
          }
        });
    },

    processExperienceFile(event) {
      this.experience.experience_image = event.target.files[0];
      this.experience.image_view = URL.createObjectURL(event.target.files[0]);
    },

    async fatchUserData() {
      const params = {
        token: 123,
        user_id: this.User.user_id,
      };
      const res = await axios.get("/api/getUserById", {
        params,
      });
      if (res.data && res.data.Status) {
        this.profile.first_name = res.data.data.userDetail.first_name
          ? res.data.data.userDetail.first_name
          : "";
        this.profile.last_name = res.data.data.userDetail.last_name
          ? res.data.data.userDetail.last_name
          : "";
        this.profile.email = res.data.data.userDetail.email
          ? res.data.data.userDetail.email
          : "";
        this.profile.address = res.data.data.userDetail.address
          ? res.data.data.userDetail.address
          : "";
        this.profile.f_name = res.data.data.userDetail.father_name
          ? res.data.data.userDetail.father_name
          : "";
        this.profile.cnic = res.data.data.userDetail.cnic
          ? res.data.data.userDetail.cnic
          : "";
        this.profile.gender = res.data.data.userDetail.gender
          ? res.data.data.userDetail.gender
          : "";
        this.profile.religion = res.data.data.userDetail.religion
          ? res.data.data.userDetail.religion
          : "";
        this.profile.dob = res.data.data.userDetail.dob
          ? res.data.data.userDetail.dob
          : "";
        this.profile.occupation = res.data.data.userDetail.occupation
          ? res.data.data.userDetail.occupation
          : "";
        this.profile.country = res.data.data.userDetail.country
          ? res.data.data.userDetail.country
          : "";
        this.profile.city = res.data.data.userDetail.city
          ? res.data.data.userDetail.city
          : "";
        this.profile.image_path = res.data.data.userDetail.image_path
          ? res.data.data.userDetail.image_path
          : "";
        this.profile.about = res.data.data.userDetail.about
          ? res.data.data.userDetail.about
          : "";
        this.is_profile_completed =
          res.data.data.userDetail.mentor.is_profile_completed;
        if (res.data.data.userDetail.online_status == "online") {
          this.profile.online_status = true;
        }
        if (res.data.data.userDetail.online_status == "offline") {
          this.profile.online_status = false;
        }
        if (res.data.data.userDetail.mentor.is_live == 1) {
          this.profile.go_live_status = true;
        } else {
          this.profile.go_live_status = false;
        }
        // if (res.data.data.userDetail.schedule.fee) {
        //   this.go_live_fee = res.data.data.userDetail.schedule.fee ? res.data.data.userDetail.schedule.fee : '';
        // }
        this.loading = false;
      }
    },
    async fetchCountries() {
      const params = {
        token: 123,
      };
      const res = await axios.get("/api/countries", {
        params,
      });
      if (res.data && res.data.Status) {
        this.countries = res.data.data.countries;
      }
      if (this.profile.country) {
        this.fetchMountedCities(this.profile.country);
      }
    },
    async fetchOccupations() {
      const params = {
        token: 123,
      };
      const res = await axios.get("/api/occupationList", { params });
      if (res.data && res.data.Status) {
        this.occupations = res.data.data.mentorOccupation;
      }
    },
    async fetchCities(event) {
      var country_id = event.target.value;

      const params = {
        token: 123,
        country_id: country_id,
      };
      const res = await axios.get("/api/cities", {
        params,
      });
      if (res.data && res.data.Status) {
        this.cities = res.data.data.cities;
      }
    },
    async fetchMountedCities(event) {
      var country_id = event;

      const params = {
        token: 123,
        country_id: country_id,
      };
      const res = await axios.get("/api/cities", {
        params,
      });
      if (res.data && res.data.Status) {
        this.cities = res.data.data.cities;
      }
    },
    async submitProfileInfo(e) {
      if (this.profile.address == "") {
        this.profile.address = document.getElementById("map").value;
      }
      var self = this;
      var toast = this.$toasted;
      e.preventDefault();
      const headers = {
        "Content-Type": "multipart/form-data",
      };

      let formData = new FormData();
      formData.append("picture", this.profile.picture);
      formData.append("token", this.profile.token);
      formData.append("mentor_id", this.User.user_id);
      formData.append("first_name", this.profile.first_name);
      formData.append("last_name", this.profile.last_name);
      //   formData.append("email", this.profile.email);
      formData.append("address", this.profile.address);
      formData.append("father_name", this.profile.f_name);
      formData.append("cnic", this.profile.cnic);
      formData.append("gender", this.profile.gender);
      formData.append("religion", this.profile.religion);
      formData.append("dob", this.profile.dob);
      formData.append("occupation", this.profile.occupation);
      formData.append("country", this.profile.country);
      formData.append("city", this.profile.city);
      formData.append("about", this.profile.about);
      this.errors = {};
      const res = await axios
        .post("/api/updateMentorProfile", formData, {
          headers: headers,
        })
        .then((res) => {
          if (res.data.Status) {
            toast.success(res.data.msg);
            document
              .getElementById("pills-educational-tab")
              .classList.remove("disabled");
            document.getElementById("pills-educational-tab").click();
            this.educationalTab();
          }
          if (!res.data.Status) {
            for (const property in res.data.errors) {
              //   this.$toasted.error(res.data.errors[property][0]);
            }
            this.errors = res.data.errors;
          }
        });
    },
    getAddressData: function (addressData, placeResultData, id) {
      this.profile.address = placeResultData.formatted_address;
    },
    async submitExperienceForm(e) {
      var self = this;
      var toast = this.$toasted;
      e.preventDefault();
      const headers = {
        "Content-Type": "multipart/form-data",
      };

      let formData = new FormData();
      formData.append("image", this.experience.experience_image);
      formData.append("token", this.experience.token);
      formData.append("mentor_id", this.User.user_id);
      formData.append("company", this.experience.company_name);
      formData.append("from", this.experience.date_from);
      formData.append("to", this.experience.date_to);
      const res = await axios
        .post("/api/mentorExperience", formData, {
          headers: headers,
        })
        .then((res) => {
          if (res.data.Status) {
            toast.success(res.data.msg);
            $(".modal").modal("hide");
            $("body").removeClass("modal-open");
            $(".modal-backdrop").remove();
            self.allExperiences.push(res.data.data.experience);
            self.experience.company_name = "";
            self.experience.date_from = "";
            self.experience.date_to = "";
            self.experience.image_view = "";
            $("#experience_image").val("");
          }
          if (!res.data.Status) {
            // toast.error("Please Fill all Fields...");
            this.errors = res.data.errors;
          }
        });
    },
    makeChildrens(categories) {
      var new_categories = [];
      categories.forEach((category, index) => {
        let cat = {
          id: category.id,
          label: category.name,
        };
        if (category.sub_categories && category.sub_categories.length > 0) {
          cat.children = this.makeChildrens(category.sub_categories);
        }
        new_categories.push(cat);
      });
      return new_categories;
    },
    resetSkills() {
      this.categoriesFilteroptions = [];
      this.selectedSubCategories = null;
      this.selectedCategories = [];
    },
  },
  created() {
    this.checkLoggedIn();
    this.mentor_id = this.User.user_id;

    const dateFormatter = Intl.DateTimeFormat("sv-SE");

    // Use the formatter to format the date
    this.minDatetime = dateFormatter.format(new Date());
    if (this.profile.online_status) {
      this.show_status = "online";
    } else {
      this.show_status = "offline";
    }
  },
  mounted() {
    if (this.is_loggedIn && this.User.role == "Mentor") {
    } else {
      window.location.href = this.url + "/login";
      this.$toasted.error("Please Login First");
    }
    this.fatchUserData();
    this.fetchCountries();
    this.fetchOccupations();
  },

};
</script>
