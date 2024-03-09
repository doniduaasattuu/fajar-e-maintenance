<x-app-layout>

    <section>
        <x-breadcumb-table :title='$title' :table="'Motors'" :action='"Instal dismantle"' />
        <x-alert-info :information='["Only installed motors can be dismantled.", "Only available motors can be installed.", "Dismantled motor automatically changes status to repair."]' />
    </section>

    @if ($errors->any())
    <x-alerts :errors='$errors' />
    @endif

    <section>
        <form onkeypress="return JS.preventSubmitForm(event)" action="/motor-install-dismantle" method="post">
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

    <script>
        window.onload = async () => {

        };
    </script>

    <script type="module">
        let token = <?php echo json_encode(csrf_token()) ?>

        JS.doFetchEquipment(token, 'motor');
        JS.callEnableButtonSwap();
    </script>
</x-app-layout>