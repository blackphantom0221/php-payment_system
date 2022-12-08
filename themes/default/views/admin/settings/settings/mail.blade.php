<div class="hidden mt-3" id="tab-mail">
    <form method="POST" enctype="multipart/form-data" class="mb-3" action="{{ route('admin.settings.email') }}">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2">
            <div class="relative m-4 group">
                <input type="text" class="form-input peer @error('mail_username') is-invalid @enderror" placeholder=" "
                    name="mail_username" value="{{ config('mail.username') }}" />
                <label class="form-label">{{ __('Mail Username') }}</label>
            </div>
            <div class="relative m-4 group">
                <input type="text" class="form-input peer @error('mail_password') is-invalid @enderror"
                    placeholder=" " name="mail_password" />
                <label class="form-label">{{ __('Mail Password') }}</label>
            </div>
            <div class="relative m-4 group">
                <input type="text" class="form-input peer @error('mail_host') is-invalid @enderror" placeholder=" "
                    name="mail_host" required value="{{ config('mail.host') }}" />
                <label class="form-label">{{ __('Mail Host') }}</label>
            </div>
            <div class="relative m-4 group">
                <input type="text" class="form-input peer @error('mail_port') is-invalid @enderror" placeholder=" "
                    name="mail_port" required value="{{ config('mail.port') }}" />
                <label class="form-label">{{ __('Mail Port') }}</label>
            </div>
            <div class="relative m-4 group">
                <input type="text" class="form-input peer @error('mail_from_address') is-invalid @enderror"
                    placeholder=" " name="mail_from_address" required value="{{ config('mail.from.address') }}" />
                <label class="form-label">{{ __('Mail From Address') }}</label>
            </div>
            <div class="relative m-4 group">
                <input type="text" class="form-input peer @error('mail_from_name') is-invalid @enderror"
                    placeholder=" " name="mail_from_name" required value="{{ config('mail.from.name') }}" />
                <label class="form-label">{{ __('Mail From Name') }}</label>
            </div>
            <div class="relative m-4 group">
                <input type="checkbox" class="w-fit form-input peer @error('mail_encryption') is-invalid @enderror"
                    placeholder=" " name="mail_encryption" value="1"
                    {{ config('mail.encryption') == 1 ? 'checked' : '' }} />
                <label class="form-label" style="position: unset">{{ __('Mail Encryption(ssl)') }}</label>
            </div>
        </div>
        <div class="float-right">
            <button class="form-submit">{{ __('Submit') }}</button>
            <button type="button" class="ml-2 bg-green-500 form-submit" id="test">{{ __('Test') }}</button>
        </div>
        <script>
            $('#test').click(function() {
                $.ajax({
                    url: "{{ route('admin.settings.email.test') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        mail_username: $('input[name="mail_username"]').val(),
                        mail_password: $('input[name="mail_password"]').val(),
                        mail_host: $('input[name="mail_host"]').val(),
                        mail_port: $('input[name="mail_port"]').val(),
                        mail_from_address: $('input[name="mail_from_address"]').val(),
                        mail_from_name: $('input[name="mail_from_name"]').val(),
                        mail_encryption: $('input[name="mail_encryption"]').val(),
                    },
                    success: function(data) {
                        console.log(data);
                        if (data.success) {
                            alert('Mail sent successfully');
                        } else {
                            alert('Mail not sent');
                        }
                    }
                });
            });
        </script>

    </form>
</div>
