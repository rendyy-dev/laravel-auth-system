<form method="POST"
                                        action="{{ route('users.toggle-active', $user) }}">
                                        @csrf
                                        @method('PATCH')

                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox"
                                                class="sr-only peer"
                                                onchange="this.form.submit()"
                                                {{ $user->is_active ? 'checked' : '' }}>

                                            <div class="w-11 h-6 bg-gray-700 rounded-full peer
                                                peer-checked:bg-green-600
                                                after:content-['']
                                                after:absolute after:top-0.5 after:left-[2px]
                                                after:bg-white after:h-5 after:w-5 after:rounded-full
                                                after:transition-all
                                                peer-checked:after:translate-x-full">
                                            </div>
                                        </label>
                                    </form>