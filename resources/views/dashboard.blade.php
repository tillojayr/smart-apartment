<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 mt-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden sm:rounded-lg">
                <div class="row d-flex justify-content-around pb-5">
                    <div class="col d-flex justify-content-center">
                        <div class="card shadow" style="width: 18rem;">
                            <div class="text-center">
                                {{-- <img class="card-img-top img-fluid w-100" src="https://placehold.co/600x400" --}}
                                alt="Card image cap">
                            </div>
                            <div class="card-body">
                                <h3 class="h5">Feedback Report</h3>
                                <p class="card-text m-0">User's feedback</p>
                                <p class="card-text">View the feedback by customers</p>
                                <a href="feedback.php" class="btn btn-primary">View Details</a>
                            </div>
                        </div>
                    </div>
                    <div class="col d-flex justify-content-center">
                        <div class="card shadow" style="width: 18rem;">
                            <div class="text-center">
                                {{-- <img class="card-img-top img-fluid w-100" src="https://picsum.photos/200/300" --}}
                                alt="Card image cap">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">QR Payment</h5>
                                <p class="card-text m-0">View Billings</p>
                                <p class="card-text">View the billings of customers</p>
                                <a href="billings.php" class="btn btn-primary">Scan QR Payment</a>
                            </div>
                        </div>
                    </div>
                    <div class="col d-flex justify-content-center">
                        <div class="card shadow" style="width: 18rem;">
                            <div class="text-center">
                                {{-- <img class="card-img-top img-fluid w-100" src="https://placehold.co/600x400" --}}
                                alt="Card image cap">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">User Management</h5>
                                <p class="card-text m-0">Manage Users</p>
                                <p class="card-text">Add, edit or delete users</p>
                                <a href="manage-users.php" class="btn btn-primary">Users</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
