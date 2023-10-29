<!DOCTYPE html>
<html lang="en">

@include("utility.head")

<body>

    @include("utility.navbar")

    <div class="container py-4">

        <div class="row mb-4">
            <div class="col-md">
                <h5 class="text-secondary mb-2">Utility</h5>
                <div class="card shadow-sm rounded px-2 py-3 mb-3 mb-md-0">
                    <div class="mb-3">
                        <div class="d-flex text-secondary justify-content-between">
                            <span>Air compressor</span>
                            <span id="compressor_percent"></span>
                        </div>
                        <div class="progress" role="progressbar" aria-label="Success example" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar progress-bar-animated bg-primary" id="compressor"></div>
                        </div>
                    </div>

                    <div class="mb-2">
                        <div class="d-flex text-secondary justify-content-between">
                            <span>Water level</span>
                            <span id="water_percent"></span>
                        </div>
                        <div class="progress" role="progressbar" aria-label="Success example" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar progress-bar-animated bg-success" id="water"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md mt-auto ">
                <div class="card shadow-sm rounded px-2 py-3 mb-3 mb-md-0">
                    <div class="mb-3">
                        <div class="d-flex text-secondary justify-content-between">
                            <span>PM Power Consumption</span>
                            <span id="power_percent"></span>
                        </div>
                        <div class="progress" role="progressbar" aria-label="Success example" aria-valuemin="0" aria-valuemax="5000">
                            <div class="progress-bar progress-bar-animated bg-danger" id="power"></div>
                        </div>
                    </div>

                    <div class="mb-2">
                        <div class="d-flex text-secondary justify-content-between">
                            <span>WT level</span>
                            <span id="wwt_percent"></span>
                        </div>
                        <div class="progress" role="progressbar" aria-label="Success example" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar progress-bar-animated bg-secondary" id="wwt"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <h5 class="text-secondary mb-2">Motor</h5>
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card border-start border-top-0 border-end-0 border-bottom-0 border-opacity-75 border-5 border-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                    State
                                </div>
                                <div class="h6 mb-0 font-weight-bold text-gray-800">
                                    Running
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card border-start border-top-0 border-end-0 border-bottom-0 border-opacity-75 border-5 border-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                    Criticality
                                </div>
                                <div class="h6 mb-0 font-weight-bold text-gray-800">
                                    High
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card border-start border-top-0 border-end-0 border-bottom-0 border-opacity-75 border-5 border-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                    Load
                                </div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h6 mb-0 mr-3 font-weight-bold text-gray-800">
                                            <span id="load_percent">50</span> %
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="progress progress-sm mr-2">
                                            <div id="load" class="progress-bar bg-success" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card border-start border-top-0 border-end-0 border-bottom-0 border-opacity-75 border-5 border-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                    STATUS
                                </div>
                                <div class="h6 mb-0 font-weight-bold text-gray-800">
                                    Unsatisfactory
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-7 col-md-6 col-lg-7 mb-3">
                <h5 class="d-inline-block text-secondary">Latest Report</h5>
                <div class="card shadow pt-2">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>
                                    <svg class="me-1 mb-1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-activity" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M6 2a.5.5 0 0 1 .47.33L10 12.036l1.53-4.208A.5.5 0 0 1 12 7.5h3.5a.5.5 0 0 1 0 1h-3.15l-1.88 5.17a.5.5 0 0 1-.94 0L6 3.964 4.47 8.171A.5.5 0 0 1 4 8.5H.5a.5.5 0 0 1 0-1h3.15l1.88-5.17A.5.5 0 0 1 6 2Z" />
                                    </svg>
                                    Vibration analysis
                                </td>
                                <td>25/10/23</td>
                                <td style="text-align: right">
                                    <svg class="me-1 mb-1" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#8ac926" class="bi bi-clipboard2-check-fill" viewBox="0 0 16 16">
                                        <path d="M10 .5a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5.5.5 0 0 1-.5.5.5.5 0 0 0-.5.5V2a.5.5 0 0 0 .5.5h5A.5.5 0 0 0 11 2v-.5a.5.5 0 0 0-.5-.5.5.5 0 0 1-.5-.5Z" />
                                        <path d="M4.085 1H3.5A1.5 1.5 0 0 0 2 2.5v12A1.5 1.5 0 0 0 3.5 16h9a1.5 1.5 0 0 0 1.5-1.5v-12A1.5 1.5 0 0 0 12.5 1h-.585c.055.156.085.325.085.5V2a1.5 1.5 0 0 1-1.5 1.5h-5A1.5 1.5 0 0 1 4 2v-.5c0-.175.03-.344.085-.5Zm6.769 6.854-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708.708Z" />
                                    </svg>
                                </td>
                            </tr>
                            <tr>

                                <td>
                                    <svg class="me-1 mb-1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-display" viewBox="0 0 16 16">
                                        <path d="M0 4s0-2 2-2h12s2 0 2 2v6s0 2-2 2h-4c0 .667.083 1.167.25 1.5H11a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1h.75c.167-.333.25-.833.25-1.5H2s-2 0-2-2V4zm1.398-.855a.758.758 0 0 0-.254.302A1.46 1.46 0 0 0 1 4.01V10c0 .325.078.502.145.602.07.105.17.188.302.254a1.464 1.464 0 0 0 .538.143L2.01 11H14c.325 0 .502-.078.602-.145a.758.758 0 0 0 .254-.302 1.464 1.464 0 0 0 .143-.538L15 9.99V4c0-.325-.078-.502-.145-.602a.757.757 0 0 0-.302-.254A1.46 1.46 0 0 0 13.99 3H2c-.325 0-.502.078-.602.145z" />
                                    </svg>
                                    Thermography
                                </td>
                                <td>25/10/23</td>
                                <td style="text-align: right">
                                    <svg class="me-1 mb-1" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#8ac926" class="bi bi-clipboard2-check-fill" viewBox="0 0 16 16">
                                        <path d="M10 .5a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5.5.5 0 0 1-.5.5.5.5 0 0 0-.5.5V2a.5.5 0 0 0 .5.5h5A.5.5 0 0 0 11 2v-.5a.5.5 0 0 0-.5-.5.5.5 0 0 1-.5-.5Z" />
                                        <path d="M4.085 1H3.5A1.5 1.5 0 0 0 2 2.5v12A1.5 1.5 0 0 0 3.5 16h9a1.5 1.5 0 0 0 1.5-1.5v-12A1.5 1.5 0 0 0 12.5 1h-.585c.055.156.085.325.085.5V2a1.5 1.5 0 0 1-1.5 1.5h-5A1.5 1.5 0 0 1 4 2v-.5c0-.175.03-.344.085-.5Zm6.769 6.854-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708.708Z" />
                                    </svg>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <svg class="me-1 mb-1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                        <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z" />
                                        <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z" />
                                    </svg>
                                    Visual Inspection
                                </td>
                                <td>25/10/23</td>
                                <td style="text-align: right">
                                    <svg class="me-1 mb-1" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#8ac926" class="bi bi-clipboard2-check-fill" viewBox="0 0 16 16">
                                        <path d="M10 .5a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5.5.5 0 0 1-.5.5.5.5 0 0 0-.5.5V2a.5.5 0 0 0 .5.5h5A.5.5 0 0 0 11 2v-.5a.5.5 0 0 0-.5-.5.5.5 0 0 1-.5-.5Z" />
                                        <path d="M4.085 1H3.5A1.5 1.5 0 0 0 2 2.5v12A1.5 1.5 0 0 0 3.5 16h9a1.5 1.5 0 0 0 1.5-1.5v-12A1.5 1.5 0 0 0 12.5 1h-.585c.055.156.085.325.085.5V2a1.5 1.5 0 0 1-1.5 1.5h-5A1.5 1.5 0 0 1 4 2v-.5c0-.175.03-.344.085-.5Zm6.769 6.854-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708.708Z" />
                                    </svg>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <svg class="me-1 mb-1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-soundwave" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M8.5 2a.5.5 0 0 1 .5.5v11a.5.5 0 0 1-1 0v-11a.5.5 0 0 1 .5-.5zm-2 2a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zm4 0a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zm-6 1.5A.5.5 0 0 1 5 6v4a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm8 0a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm-10 1A.5.5 0 0 1 3 7v2a.5.5 0 0 1-1 0V7a.5.5 0 0 1 .5-.5zm12 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0V7a.5.5 0 0 1 .5-.5z" />
                                    </svg>
                                    Airborne ultrasound
                                </td>
                                <td>25/10/23</td>
                                <td style="text-align: right">
                                    <svg class="me-1 mb-1" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#8ac926" class="bi bi-clipboard2-check-fill" viewBox="0 0 16 16">
                                        <path d="M10 .5a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5.5.5 0 0 1-.5.5.5.5 0 0 0-.5.5V2a.5.5 0 0 0 .5.5h5A.5.5 0 0 0 11 2v-.5a.5.5 0 0 0-.5-.5.5.5 0 0 1-.5-.5Z" />
                                        <path d="M4.085 1H3.5A1.5 1.5 0 0 0 2 2.5v12A1.5 1.5 0 0 0 3.5 16h9a1.5 1.5 0 0 0 1.5-1.5v-12A1.5 1.5 0 0 0 12.5 1h-.585c.055.156.085.325.085.5V2a1.5 1.5 0 0 1-1.5 1.5h-5A1.5 1.5 0 0 1 4 2v-.5c0-.175.03-.344.085-.5Zm6.769 6.854-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708.708Z" />
                                    </svg>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-xs-5 col-md-6 col-lg-5">
                <h5 class="d-inline-block text-secondary mt-3 mt-md-0">Detecting faults</h5>
                <div class="card shadow pt-2">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>
                                    <svg class="me-1 mb-1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-clockwise" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2v1z" />
                                        <path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466z" />
                                    </svg>
                                    Rotating lossenes
                                </td>
                                <td style="text-align: right">
                                    <svg class="me-1 mb-1" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#8ac926" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                                    </svg>
                                </td>
                            </tr>
                            <tr>

                                <td>
                                    <svg class="me-1 mb-1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-nut" viewBox="0 0 16 16">
                                        <path d="m11.42 2 3.428 6-3.428 6H4.58L1.152 8 4.58 2h6.84zM4.58 1a1 1 0 0 0-.868.504l-3.428 6a1 1 0 0 0 0 .992l3.428 6A1 1 0 0 0 4.58 15h6.84a1 1 0 0 0 .868-.504l3.429-6a1 1 0 0 0 0-.992l-3.429-6A1 1 0 0 0 11.42 1H4.58z" />
                                        <path d="M6.848 5.933a2.5 2.5 0 1 0 2.5 4.33 2.5 2.5 0 0 0-2.5-4.33zm-1.78 3.915a3.5 3.5 0 1 1 6.061-3.5 3.5 3.5 0 0 1-6.062 3.5z" />
                                    </svg>
                                    Loose bolts
                                </td>
                                <td style="text-align: right">
                                    <svg class="me-1 mb-1" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#8ac926" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                                    </svg>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <svg class="me-1 mb-1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-droplet-half" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M7.21.8C7.69.295 8 0 8 0c.109.363.234.708.371 1.038.812 1.946 2.073 3.35 3.197 4.6C12.878 7.096 14 8.345 14 10a6 6 0 0 1-12 0C2 6.668 5.58 2.517 7.21.8zm.413 1.021A31.25 31.25 0 0 0 5.794 3.99c-.726.95-1.436 2.008-1.96 3.07C3.304 8.133 3 9.138 3 10c0 0 2.5 1.5 5 .5s5-.5 5-.5c0-1.201-.796-2.157-2.181-3.7l-.03-.032C9.75 5.11 8.5 3.72 7.623 1.82z" />
                                        <path fill-rule="evenodd" d="M4.553 7.776c.82-1.641 1.717-2.753 2.093-3.13l.708.708c-.29.29-1.128 1.311-1.907 2.87l-.894-.448z" />
                                    </svg>
                                    Fluid leaks
                                </td>
                                <td style="text-align: right">
                                    <svg class="me-1 mb-1" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#ef233c" class="bi bi-exclamation-circle-fill" viewBox="0 0 16 16">
                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                                    </svg>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <svg class="me-1 mb-1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bullseye" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                        <path d="M8 13A5 5 0 1 1 8 3a5 5 0 0 1 0 10zm0 1A6 6 0 1 0 8 2a6 6 0 0 0 0 12z" />
                                        <path d="M8 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6zm0 1a4 4 0 1 0 0-8 4 4 0 0 0 0 8z" />
                                        <path d="M9.5 8a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z" />
                                    </svg>
                                    Bearing issues
                                </td>
                                <td style="text-align: right">
                                    <svg class="me-1 mb-1" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#ff9500" class="bi bi-exclamation-circle-fill" viewBox="0 0 16 16">
                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                                    </svg>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        compressor = document.getElementById("compressor");
        water = document.getElementById("water");
        power = document.getElementById("power");
        wwt = document.getElementById("wwt");
        load = document.getElementById("load");

        setInterval(function() {
            const comp = Math.floor(Math.random() * 6) + 3
            let compressor_value = `${60 + comp}`
            compressor.style.width = compressor_value + "%";
            compressor_percent = document.getElementById("compressor_percent");
            compressor_percent.textContent = compressor_value + " psi";

            const wtr = Math.floor(Math.random() * 5) + 3
            let water_value = `${70 + wtr}`
            water.style.width = water_value + "%";
            water_percent = document.getElementById("water_percent");
            water_percent.textContent = water_value + " %";

            const pwr = Math.floor(Math.random() * 4) + 3
            let power_value = `${40 + pwr}`
            power.style.width = power_value + "%";
            power_percent = document.getElementById("power_percent");
            power_percent.textContent = (power_value + (pwr + 31)) + " kWh";

            const wt = Math.floor(Math.random() * 3) + 1
            let wwt_value = `${80 + wt}`
            wwt.style.width = wwt_value + "%";
            wwt_percent = document.getElementById("wwt_percent");
            wwt_percent.textContent = wwt_value + " %";

        }, 100);

        setInterval(function() {
            const ld = Math.floor(Math.random() * 9) + 5
            let load_value = `${80 + ld}`
            load.style.width = load_value + "%";
            load_percent = document.getElementById("load_percent");
            load_percent.textContent = load_value;

            if (Number(load_percent.textContent) > 90) {
                console.info("lebih")
                load.classList.remove("bg-warning");
                load.classList.add("bg-danger");
            } else {
                load.classList.remove("bg-danger");
                load.classList.add("bg-warning");
            }
        }, 1000);
    </script>
</body>

</html>