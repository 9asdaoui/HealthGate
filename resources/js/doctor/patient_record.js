
document.addEventListener('DOMContentLoaded', function () {
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabContents = document.querySelectorAll('.tab-content');

    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            tabButtons.forEach(btn => btn.classList.remove('active'));
            tabContents.forEach(content => content.classList.remove('active'));

            button.classList.add('active');
            document.getElementById(button.dataset.tab).classList.add('active');
        });
    });

    const modalButtons = document.querySelectorAll('[data-modal-target]');
    const modalCloseButtons = document.querySelectorAll('.modal-close');

    modalButtons.forEach(button => {
        button.addEventListener('click', () => {
            const modal = document.getElementById(button.dataset.modalTarget);
            modal.classList.remove('hidden');
        });
    });

    modalCloseButtons.forEach(button => {
        button.addEventListener('click', () => {
            const modal = button.closest('[id$="Modal"]');
            modal.classList.add('hidden');
        });
    });

    const bpCtx = document.getElementById('bloodPressureChart').getContext('2d');
    const bpChart = new Chart(bpCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($bloodPressureChartData['labels'])!!
},
    datasets: [{
        label: 'Systolic',
        data: {!! json_encode($bloodPressureChartData['systolic'])!!},
borderColor: 'rgba(239, 68, 68, 1)',
    backgroundColor: 'rgba(239, 68, 68, 0.1)',
        tension: 0.4,
            borderWidth: 2,
                fill: false
                          },
{
    label: 'Diastolic',
        data: { !!json_encode($bloodPressureChartData['diastolic'])!! },
    borderColor: 'rgba(59, 130, 246, 1)',
        backgroundColor: 'rgba(59, 130, 246, 0.1)',
            tension: 0.4,
                borderWidth: 2,
                    fill: false
}
                      ]
                  },
options: {
    responsive: true,
        maintainAspectRatio: false,
            scales: {
        y: {
            beginAtZero: false,
                min: 40,
                    title: {
                display: true,
                    text: 'mmHg'
            }
        },
        x: {
            title: {
                display: true,
                    text: 'Date'
            }
        }
    }
}
              });

const bsCtx = document.getElementById('bloodSugarChart').getContext('2d');
const bsChart = new Chart(bsCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode($bloodSugarChartData['labels'])!!},
datasets: [{
    label: 'Blood Sugar',
    data: {!! json_encode($bloodSugarChartData['values']) !!},
borderColor: 'rgba(139, 92, 246, 1)',
    backgroundColor: 'rgba(139, 92, 246, 0.1)',
        tension: 0.4,
            borderWidth: 2,
                fill: true
                      }]
                  },
options: {
    responsive: true,
        maintainAspectRatio: false,
            scales: {
        y: {
            beginAtZero: false,
                title: {
                display: true,
                    text: 'mg/dL'
            }
        },
        x: {
            title: {
                display: true,
                    text: 'Date'
            }
        }
    }
}
              });

const hrCtx = document.getElementById('heartRateChart').getContext('2d');
const hrChart = new Chart(hrCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode($heartRateChartData['labels'])!!},
datasets: [{
    label: 'Heart Rate',
    data: {!! json_encode($heartRateChartData['values']) !!},
borderColor: 'rgba(37, 99, 235, 1)',
    backgroundColor: 'rgba(37, 99, 235, 0.1)',
        tension: 0.4,
            borderWidth: 2,
                fill: true
                      }]
                  },
options: {
    responsive: true,
        maintainAspectRatio: false,
            scales: {
        y: {
            beginAtZero: false,
                title: {
                display: true,
                    text: 'bpm'
            }
        },
        x: {
            title: {
                display: true,
                    text: 'Date'
            }
        }
    }
}
              });
          });

function printRaport() {
    const patientInfo = {
        name: "{{ $patient->user->first_name }} {{ $patient->user->last_name }}",
        id: "{{ $patient->id }}",
        age: "{{ \Carbon\Carbon::parse($patient->birth_date)->age }}",
        gender: "{{ ucfirst($patient->gender) }}",
        height: "{{ $patient->height ?? '---' }}",
        weight: "{{ $patient->weight ?? '---' }}",
        email: "{{ $patient->user->email }}",
        phone: "{{ $patient->phone ?? 'No phone number' }}",
        address: "{{ $patient->address ?? 'No address provided' }}"
    };

    const currentDate = new Date().toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });

    let reportHTML = `
                                  <div style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; max-width: 850px; margin: 0 auto; padding: 30px; color: #333;">
                                      <div style="text-align: center; margin-bottom: 30px;">
                                          <h1 style="color: #2563EB; font-size: 28px; margin-bottom: 8px;">Patient Medical Report</h1>
                                          <p style="color: #6B7280; font-size: 14px;">Generated on ${currentDate}</p>
                                      </div>
                                      
                                      <!-- Patient Info Card -->
                                      <div style="background-color: #F8FAFC; border-radius: 12px; padding: 24px; margin-bottom: 36px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
                                          <div style="display: flex; flex-wrap: wrap; gap: 20px;">
                                              <div style="flex: 2; min-width: 280px;">
                                                  <h2 style="color: #1E40AF; font-size: 22px; margin-top: 0; margin-bottom: 12px;">${patientInfo.name}</h2>
                                                  <div style="display: flex; flex-wrap: wrap; gap: 15px;">
                                                      <div style="background-color: #EFF6FF; padding: 8px 12px; border-radius: 6px; font-size: 14px;">
                                                          <span style="color: #6B7280;">Patient ID:</span> 
                                                          <span style="font-weight: 600; color: #2563EB;">#${patientInfo.id}</span>
                                                      </div>
                                                      <div style="background-color: #EFF6FF; padding: 8px 12px; border-radius: 6px; font-size: 14px;">
                                                          <span style="color: #6B7280;">Age:</span> 
                                                          <span style="font-weight: 600;">${patientInfo.age} years</span>
                                                      </div>
                                                      <div style="background-color: #EFF6FF; padding: 8px 12px; border-radius: 6px; font-size: 14px;">
                                                          <span style="color: #6B7280;">Gender:</span> 
                                                          <span style="font-weight: 600;">${patientInfo.gender}</span>
                                                      </div>
                                                  </div>
                                                  <div style="margin-top: 15px;">
                                                      <p style="margin: 5px 0; display: flex;">
                                                          <span style="min-width: 120px; color: #6B7280;">Height:</span>
                                                          <span style="font-weight: 500;">${patientInfo.height} cm</span>
                                                      </p>
                                                      <p style="margin: 5px 0; display: flex;">
                                                          <span style="min-width: 120px; color: #6B7280;">Weight:</span>
                                                          <span style="font-weight: 500;">${patientInfo.weight} kg</span>
                                                      </p>
                                                  </div>
                                              </div>
                                              <div style="flex: 1; min-width: 280px; border-left: 1px solid #E5E7EB; padding-left: 20px;">
                                                  <h3 style="color: #6B7280; text-transform: uppercase; font-size: 12px; margin-top: 0; letter-spacing: 1px;">Contact Information</h3>
                                                  <p style="margin: 8px 0; display: flex; align-items: center;">
                                                      <span style="margin-right: 10px; color: #6B7280;">📧</span>
                                                      ${patientInfo.email}
                                                  </p>
                                                  <p style="margin: 8px 0; display: flex; align-items: center;">
                                                      <span style="margin-right: 10px; color: #6B7280;">📱</span>
                                                      ${patientInfo.phone}
                                                  </p>
                                                  <p style="margin: 8px 0; display: flex; align-items: center;">
                                                      <span style="margin-right: 10px; color: #6B7280;">🏠</span>
                                                      ${patientInfo.address}
                                                  </p>
                                              </div>
                                          </div>
                                      </div>
                                      
                                      <!-- Medical Conditions Section -->
                                      <div style="margin-bottom: 36px;">
                                          <h2 style="color: #1E40AF; font-size: 20px; display: flex; align-items: center; gap: 10px; margin-bottom: 16px;">
                                              <span style="display: inline-block; width: 24px; height: 24px; background-color: #DBEAFE; border-radius: 50%; text-align: center; line-height: 24px; color: #2563EB;">🩺</span>
                                              Medical Conditions
                                          </h2>
                                          <div style="background-color: white; border-radius: 10px; padding: 1px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                                              <ul style="list-style-type: none; padding: 15px;">
                                                  @foreach ($patient->diseases as $disease)
                                                      <li style="margin-bottom: 14px; padding-bottom: 14px; border-bottom: 1px solid #F3F4F6;">
                                                          <strong style="color: #1E40AF; display: block; margin-bottom: 4px;">{{ $disease->name }}</strong>
                                                          <span style="color: #4B5563; font-size: 14px;">{{ $disease->description }}</span>
                                                      </li>
                                                  @endforeach
                                                  @if (count($patient->diseases) == 0)
                                                      <li style="color: #6B7280; font-style: italic; padding: 10px;">No medical conditions recorded</li>
                                                  @endif
                                              </ul>
                                          </div>
                                      </div>
                                      
                                      <!-- Medical Records Section -->
                                      <div style="margin-bottom: 36px;">
                                          <h2 style="color: #1E40AF; font-size: 20px; display: flex; align-items: center; gap: 10px; margin-bottom: 16px;">
                                              <span style="display: inline-block; width: 24px; height: 24px; background-color: #DBEAFE; border-radius: 50%; text-align: center; line-height: 24px; color: #2563EB;">📋</span>
                                              Medical Records
                                          </h2>
                                          <div style="overflow-x: auto; background-color: white; border-radius: 10px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                                              <table style="width: 100%; border-collapse: collapse; margin-bottom: 0;">
                                                  <thead>
                                                      <tr style="background-color: #F1F5F9; text-align: left;">
                                                          <th style="padding: 12px 16px; border-bottom: 1px solid #E5E7EB; font-weight: 600; color: #1E40AF;">Date</th>
                                                          <th style="padding: 12px 16px; border-bottom: 1px solid #E5E7EB; font-weight: 600; color: #1E40AF;">Record</th>
                                                          <th style="padding: 12px 16px; border-bottom: 1px solid #E5E7EB; font-weight: 600; color: #1E40AF;">Doctor</th>
                                                          <th style="padding: 12px 16px; border-bottom: 1px solid #E5E7EB; font-weight: 600; color: #1E40AF;">Medication</th>
                                                      </tr>
                                                  </thead>
                                                  <tbody>
                                                      @foreach ($medicalRecords as $record)
                                                          <tr>
                                                              <td style="padding: 16px; border-bottom: 1px solid #F3F4F6; white-space: nowrap; color: #6B7280; font-size: 14px;">
                                                                  {{ \Carbon\Carbon::parse($record->start_date)->format('M d, Y') }}
                                                              </td>
                                                              <td style="padding: 16px; border-bottom: 1px solid #F3F4F6;">
                                                                  <div style="margin-bottom: 4px; font-weight: 600; color: #1E40AF;">{{ $record->name }}</div>
                                                                  <div style="color: #4B5563; font-size: 14px;">{{ $record->description }}</div>
                                                              </td>
                                                              <td style="padding: 16px; border-bottom: 1px solid #F3F4F6; color: #4B5563;">
                                                                  Dr. {{ $record->doctor->user->first_name ?? 'Unknown' }} 
                                                                  {{ $record->doctor->user->last_name ?? '' }}
                                                              </td>
                                                              <td style="padding: 16px; border-bottom: 1px solid #F3F4F6; color: #4B5563;">
                                                                  <span style="display: inline-block; background-color: #EFF6FF; padding: 4px 10px; border-radius: 4px; font-size: 14px;">
                                                                      {{ $record->dosage }} {{ $record->frequency }}
                                                                  </span>
                                                              </td>
                                                          </tr>
                                                      @endforeach
                                                      @if (count($medicalRecords) == 0)
                                                          <tr>
                                                              <td colspan="4" style="padding: 16px; text-align: center; color: #6B7280; font-style: italic;">
                                                                  No medical records available
                                                              </td>
                                                          </tr>
                                                      @endif
                                                  </tbody>
                                              </table>
                                          </div>
                                      </div>
                                      
                                      <!-- Health Metrics Section -->
                                      <div style="margin-bottom: 36px;">
                                          <h2 style="color: #1E40AF; font-size: 20px; display: flex; align-items: center; gap: 10px; margin-bottom: 16px;">
                                              <span style="display: inline-block; width: 24px; height: 24px; background-color: #DBEAFE; border-radius: 50%; text-align: center; line-height: 24px; color: #2563EB;">📊</span>
                                              Latest Health Metrics
                                          </h2>
                                          <div style="display: flex; flex-wrap: wrap; gap: 15px;">
                                              <!-- Blood Pressure Card -->
                                              <div style="flex: 1; min-width: 220px; background-color: white; border-radius: 10px; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                                                  <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 15px;">
                                                      <div style="width: 36px; height: 36px; border-radius: 50%; background-color: #EFF6FF; display: flex; align-items: center; justify-content: center;">
                                                          <span style="color: #2563EB; font-weight: bold; font-size: 16px;">BP</span>
                                                      </div>
                                                      <h3 style="margin: 0; color: #1E40AF; font-size: 16px;">Blood Pressure</h3>
                                                  </div>
                                                  @if (count($bloodPressureChartData['labels']) > 0)
                                                      <div style="font-size: 24px; font-weight: 600; color: #1E3A8A; margin-bottom: 8px;">
                                                          {{ end($bloodPressureChartData['systolic']) }}/{{ end($bloodPressureChartData['diastolic']) }} 
                                                          <span style="font-size: 14px; font-weight: normal; color: #6B7280;">mmHg</span>
                                                      </div>
                                                      <div style="color: #6B7280; font-size: 14px;">
                                                          Measured on {{ end($bloodPressureChartData['labels']) }}
                                                      </div>
                                                  @else
                                                      <div style="color: #6B7280; font-style: italic;">No readings available</div>
                                                  @endif
                                              </div>
                                              
                                              <!-- Blood Sugar Card -->
                                              <div style="flex: 1; min-width: 220px; background-color: white; border-radius: 10px; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                                                  <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 15px;">
                                                      <div style="width: 36px; height: 36px; border-radius: 50%; background-color: #ECFDF5; display: flex; align-items: center; justify-content: center;">
                                                          <span style="color: #059669; font-weight: bold; font-size: 16px;">BS</span>
                                                      </div>
                                                      <h3 style="margin: 0; color: #065F46; font-size: 16px;">Blood Sugar</h3>
                                                  </div>
                                                  @if (count($bloodSugarChartData['labels']) > 0)
                                                      <div style="font-size: 24px; font-weight: 600; color: #065F46; margin-bottom: 8px;">
                                                          {{ end($bloodSugarChartData['values']) }} 
                                                          <span style="font-size: 14px; font-weight: normal; color: #6B7280;">mg/dL</span>
                                                      </div>
                                                      <div style="color: #6B7280; font-size: 14px;">
                                                          Measured on {{ end($bloodSugarChartData['labels']) }}
                                                      </div>
                                                  @else
                                                      <div style="color: #6B7280; font-style: italic;">No readings available</div>
                                                  @endif
                                              </div>
                                              
                                              <!-- Heart Rate Card -->
                                              <div style="flex: 1; min-width: 220px; background-color: white; border-radius: 10px; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                                                  <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 15px;">
                                                      <div style="width: 36px; height: 36px; border-radius: 50%; background-color: #FEF2F2; display: flex; align-items: center; justify-content: center;">
                                                          <span style="color: #DC2626; font-weight: bold; font-size: 16px;">HR</span>
                                                      </div>
                                                      <h3 style="margin: 0; color: #991B1B; font-size: 16px;">Heart Rate</h3>
                                                  </div>
                                                  @if (count($heartRateChartData['labels']) > 0)
                                                      <div style="font-size: 24px; font-weight: 600; color: #991B1B; margin-bottom: 8px;">
                                                          {{ end($heartRateChartData['values']) }} 
                                                          <span style="font-size: 14px; font-weight: normal; color: #6B7280;">bpm</span>
                                                      </div>
                                                      <div style="color: #6B7280; font-size: 14px;">
                                                          Measured on {{ end($heartRateChartData['labels']) }}
                                                      </div>
                                                  @else
                                                      <div style="color: #6B7280; font-style: italic;">No readings available</div>
                                                  @endif
                                              </div>
                                          </div>
                                      </div>
                                      
                                      <!-- Footer -->
                                      <div style="text-align: center; margin-top: 50px; padding: 20px 0; border-top: 1px solid #E5E7EB; color: #6B7280; font-size: 14px;">
                                          <div style="margin-bottom: 10px;">
                                              This report was generated by <span style="color: #2563EB; font-weight: 600;">HealthGate</span> - Patient Management System
                                          </div>
                                          <div style="background-color: #F1F5F9; display: inline-block; padding: 8px 16px; border-radius: 30px;">
                                              Attending Physician: Dr. {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}
                                          </div>
                                          <div style="margin-top: 15px; font-size: 12px;">
                                              Confidential medical information - For authorized personnel only
                                          </div>
                                      </div>
                                  </div>`;


    document.body.innerHTML = reportHTML;
    window.print();
    location.reload();
}

window.printRaport = printRaport;
window.bpChart = bpChart;
window.bsChart = bsChart;
window.hrChart = hrChart;

// // Expose helper functions if needed for external scripts
// window.toggleModal = function(modalId) {
//     const modal = document.getElementById(modalId);
//     if (modal) {
//         modal.classList.toggle('hidden');
//     }
// };

// window.closeAllModals = function() {
//     const modals = document.querySelectorAll('[id$="Modal"]');
//     modals.forEach(modal => {
//         modal.classList.add('hidden');
//     });
// };