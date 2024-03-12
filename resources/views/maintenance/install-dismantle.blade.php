<x-app-layout>

    <section>
        <x-breadcumb-table :title='$title' :table="$table" :action='$title' />
        <x-alert-info :information='["Only installed " . strtolower($table) . " can be dismantled.",  "Only available " . strtolower($table) . " can be installed.", "Dismantled " . strtolower($table) . " automatically changes status to repair."]' />
    </section>

    @if ($errors->any())
    <x-alerts :errors='$errors' />
    @endif

    <section>
        <form onkeypress="return JS.preventSubmitForm(event)" action="/{{ request()->path() }}" method="POST">
            @csrf

            <div class="row">

                <!-- FORM DISMANTLED -->
                <div class="pe-1 col">
                    <div>
                        <x-install-dismantle.form-dismantle>
                            {{ __('Dismantled equipment.') }}
                        </x-install-dismantle.form-dismantle>

                        <div id="dismantle_field">
                            <!-- DATA RENDER HERE -->
                        </div>
                    </div>
                </div>

                <!-- ================================================================================================================================================================================ -->

                <div class="ps-1 col">
                    <div>
                        <x-install-dismantle.form-install>
                            {{ __('Installed equipment.') }}
                        </x-install-dismantle.form-install>

                        <div id="install_field">
                            <!-- DATA RENDER HERE -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- BUTTON SUBMIT -->
            <x-install-dismantle.button-swap-full>
                {{ __('Swap') }}
            </x-install-dismantle.button-swap-full>

        </form>
    </section>

    <script type="module">
        let equipment_type = <?php echo json_encode(strtolower(substr_replace($table, "", -1))) ?>;
        let token = <?php echo json_encode(csrf_token()) ?>

        JS.doFetchEquipment(token, equipment_type);
        JS.callEnableButtonSwap();
    </script>
</x-app-layout>