<div class="px-2">
    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .5s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .5s;
        }

        input:checked+.slider {
            background-color: #ff6f00;
        }

        input:checked+.slider:before {
            transform: translateX(26px);
        }

        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }

        .card {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            transition: 0.3s;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .card:hover {
            box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
        }

        .card-header {
            font-weight: bold;
            font-size: 1.25rem;
            background-color: #ff8b33;
            color: white;
            padding: 10px;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
        }

        .card-body {
            padding: 20px;
            background-color: #fff;
            border-bottom-left-radius: 5px;
            border-bottom-right-radius: 5px;
        }

        .card-body p {
            margin: 10px 0;
        }

        .control-group {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .control-group p {
            margin: 0;
            font-size: 1.1rem;
            font-weight: bold;
        }

        .control-group label {
            margin: 0 10px;
        }

        .control-group.vertical {
            flex-direction: column;
            align-items: flex-start;
        }

        .control-group.vertical p {
            margin-bottom: 10px;
        }

        .control-group.vertical .switch {
            margin-bottom: 10px;
        }

        .control-group.horizontal {
            flex-direction: row;
            justify-content: space-around;
        }

        .control-group.horizontal p {}
    </style>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if (session()->has('message'))
            <div class="alert bg-electric-orange-100 border-electric-orange-400 text-electric-orange-700 alert-dismissible fade show"
                role="alert">
                {{ __(session('message')) }}
                <button type="button" class="btn-close text-electric-orange-700" data-bs-dismiss="alert"
                    aria-label="Close"></button>
            </div>
        @endif
        @if (session()->has('error'))
            <div class="alert bg-red-100 border-red-400 text-red-700 px-4 py-3 alert-dismissible fade show"
                role="alert">
                {{ __(session('error')) }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="row">
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-header">
                        Admin Control
                    </div>
                    <div class="card-body text-center">
                        <div class="control-group horizontal">
                            <div>
                                <h3 class="h4">Voltage</h3>
                                <h4 class="h4 text-electric-orange-500"><span
                                        id="admin-voltage">{{ $owner->volts }}</span></h4>
                            </div>
                            <div>
                                <h3 class="h4">Consumed</h3>
                                <h4 class="h4 text-electric-orange-500"><span id="admin-voltage">{{ $owner->consumed }}
                                        kw/h</span></h4>
                            </div>
                            <div>
                                <h3 class="h4">Current</h3>
                                <h4 class="h4 text-electric-orange-500"><span id="admin-current">{{ $owner->current }}
                                        A</span></h4>
                            </div>
                        </div>
                        <!-- <div class="control-group horizontal">
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider round"></span>
                            </label>
                            <p>Outlet</p>
                        </div> -->
                    </div>
                </div>
            </div>
            @foreach ($rooms as $room)
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header">
                            Room {{ $room->room_number }}
                        </div>
                        <div class="card-body text-center">
                            <div class="control-group horizontal">
                                <div>
                                    <h3 class="h4">Voltage</h3>
                                    <h4 class="h4 text-electric-orange-500"><span id="room1-voltage">{{ $room->volts }}
                                            V</span></h4>
                                </div>
                                <div>
                                    <h3 class="h4">Consumed</h3>
                                    <h4 class="h4 text-electric-orange-500"><span
                                            id="room1-current">{{ $room->consumed }} kw/h</span></h4>
                                </div>
                                <div>
                                    <h3 class="h4">Current</h3>
                                    <h4 class="h4 text-electric-orange-500"><span
                                            id="room1-current">{{ $room->current }} A</span></h4>
                                </div>
                            </div>
                            <div class="control-group horizontal">
                                <label class="switch">
                                    <input type="checkbox" wire:model.live="outlet_switch.{{ $room->id }}">
                                    <span class="slider round"></span>
                                </label>

                                <label class="switch">
                                    <input type="checkbox" wire:model.live="light_switch.{{ $room->id }}">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                            <div class="control-group horizontal">
                                <p class="text-electric-orange-500">Outlet</p>
                                <p class="text-electric-orange-500">Light</p>
                            </div>
                            <div>
                                @if ($room->flag == '1')
                                    <p class="italic text-electric-orange-400">Rent already paid?</p>
                                    <button
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-electric-orange-500 hover:bg-electric-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-electric-orange-500"
                                        wire:click="changeFlagRoom({{ $room->id }}, 0)">

                                        Activate
                                    </button>
                                @else
                                    <p class="italic text-electric-orange-400">Not paying rent?</p>
                                    <button
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-electric-orange-500 hover:bg-electric-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-electric-orange-500"
                                        wire:click="changeFlagRoom({{ $room->id }}, 1)">

                                        Deactivate
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
