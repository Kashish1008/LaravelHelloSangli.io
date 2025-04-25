<style>
    .d-none {
        display: none;
    }
</style>
<div class="container-fluid mt-3 d-none" id="jobtype_list">
    <div class="row">
        <div class="col-12">
            <h3 class="fs-4">Job Type List</h3>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-12">
            <input type="text" id="searchInput" class="form-control" placeholder="Search Job Type..." onkeyup="filterTable()">
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="bg-light">
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Job Type</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody id="jobTypeTable">
                        @if ($type_list->isNotEmpty())
                        @foreach ($type_list as $jtype)
                        <tr>
                            <td class="align-middle">{{ $jtype->id }}</td>
                            <td class="align-middle">{{ $jtype->name }}</td>
                            <td class="align-middle">
                                <button id="toggleButton{{ $jtype->id }}"
                                    class="btn btn-sm {{ $jtype->status == 1 ? 'btn-success' : 'btn-danger' }}"
                                    onclick="toggleStatus({{ $jtype->id }}, {{ $jtype->status == 1 ? 0 : 1 }})">
                                    {{ $jtype->status == 1 ? 'Active' : 'Inactive' }}
                                </button>

                                <!-- CSRF Token Meta (If not already present) -->
                                <meta name="csrf-token" content="{{ csrf_token() }}">

                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="3" class="text-center">No Job Type Available</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div>
        {!! $type_list->links() !!}
    </div>
</div>

<script>
    function jobtyp_list() {
        var type_list = document.getElementById("jobtype_list");
        type_list.classList.toggle("d-none");
    }
</script>

<script>
    function toggleStatus(jobtypeId, newStatus) {
        let url = "{{ route('account.updateJobTypeStatus') }}"; // Use a single route without parameters

        fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    jobtypeId: jobtypeId,
                    status: newStatus
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP Error! Status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    let button = document.getElementById(`toggleButton${jobtypeId}`);
                    if (newStatus === 1) {
                        button.innerText = "Active";
                        button.classList.remove("btn-danger");
                        button.classList.add("btn-success");
                        button.setAttribute("onclick", `toggleStatus(${jobtypeId}, 0)`);
                    } else {
                        button.innerText = "Inactive";
                        button.classList.remove("btn-success");
                        button.classList.add("btn-danger");
                        button.setAttribute("onclick", `toggleStatus(${jobtypeId}, 1)`);
                    }
                } else {
                    alert("Failed to update status!");
                }
            })
            .catch(error => console.error("Error:", error));
    }
    function filterTable() {
        let input = document.getElementById("searchInput").value.toLowerCase();
        let rows = document.querySelectorAll("#jobTypeTable tr");

        rows.forEach(row => {
            let jobType = row.getElementsByTagName("td")[1]; // Get Job Type column
            if (jobType) {
                let textValue = jobType.textContent || jobType.innerText;
                row.style.display = textValue.toLowerCase().includes(input) ? "" : "none";
            }
        });
    }
</script>