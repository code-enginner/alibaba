@php use Illuminate\Support\Facades\Auth;use function PHPUnit\Framework\isNan;use function PHPUnit\Framework\isNull; @endphp
<div class="flex flex-col">
    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
            <div class="overflow-hidden">
                <table
                    class="min-w-full text-left text-sm font-light text-surface dark:text-white"
                >
                    <thead
                        class="border-b border-neutral-200 font-medium dark:border-white/10"
                    >
                    <tr>
                        <th scope="col"
                            class="px-6 py-4 text-center"
                        >#
                        </th>
                        <th scope="col"
                            class="px-6 py-4 text-center"
                        >Title
                        </th>
                        <th scope="col"
                            class="px-6 py-4 text-center"
                        >Author
                        </th>
                        <th scope="col"
                            class="px-6 py-4 text-center"
                        >Publish Date
                        </th>
                        <th scope="col"
                            class="px-6 py-4 text-center"
                        >Settings
                        </th>
                    </tr>
                    </thead>

                    <tbody>
                    @if(count($articles) === 0)
                        <tr class="border-b border-neutral-200 dark:border-white/10">
                            <td colspan="5"
                                class="whitespace-nowrap px-6 py-4 font-medium text-center text-2xl text-[#f44336]"
                            >{{ __('!هیچ مقاله ای ثبت نشده') }}</td>
                        </tr>

                    @else

                        @foreach($articles as $article)
                            <tr class="border-b border-neutral-200 dark:border-white/10">
                                <td class="text-center whitespace-nowrap px-6 py-4 font-medium">{{ ++$loop->index }}</td>
                                <td class="text-center whitespace-nowrap px-6 py-4">{{ $article->title }}</td>
                                <td class="text-center whitespace-nowrap px-6 py-4">{{ $article->user->full_name }}</td>
                                <td class="text-center whitespace-nowrap px-6 py-4">{{ $article->publish_date }}</td>
                                <td class="text-center whitespace-nowrap px-6 py-4">
                                    <a class="inline-block p-2 cursor-pointer mx-2 border bg-[#e1f5fe] border-[#03a9f4] rounded text-[#01579b]"
                                       href="{{ route('articles.show', [$article->id]) }}"
                                    >مشاهده مقاله</a>

                                    @if(Auth::guard('web')->check())
                                        @can( 'update', $article)
                                            <a class="inline-block p-2 cursor-pointer mx-2 border bg-[#fffde7] border-[#fdd835] rounded text-[#f57f17]"
                                               href="{{ url("articles/{$article->id}/edit") }}"
                                            >ویرایش</a>
                                        @endcan
                                    @endif

                                    {{--@if(Auth::guard('admin')->check())
                                        <a class="inline-block p-2 cursor-pointer mx-2 border bg-[#fffde7] border-[#fdd835] rounded text-[#f57f17]"
                                           href="{{ url("articles/{$article->id}/edit") }}"
                                        >ویرایش</a>
                                    @endif--}}

                                    @if(Auth::guard('admin')->check())
                                        @if($article->deleted_at === NULL)
                                            <form class="inline-block"
                                                  action="{{ route('delete.article', ['article' => $article->id]) }}"
                                                  method="POST"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="inline-block p-2 cursor-pointer mx-2 border bg-[#ffebee] border-[#f44336] rounded text-[#f44336]"
                                                >حذف
                                                </button>
                                            </form>
                                        @else
                                            <form class="inline-block"
                                                  action="{{ route('restore.article', ['article' => $article->id]) }}"
                                                  method="POST"
                                            >
                                                @csrf

                                                <button type="submit"
                                                        class="inline-block p-2 cursor-pointer mx-2 border bg-[#fff8e1] border-[#ffc107] rounded text-[#ffc107]"
                                                >بازیابی
                                                </button>
                                            </form>
                                        @endif
                                    @endif

                                    @if(Auth::guard('admin')->user())
                                        @if($article->approve_status)
                                            <form class="inline-block"
                                                  action="{{ route('article.approve.article') }}"
                                                  method="POST"
                                            >
                                                @csrf
                                                <input type="hidden"
                                                       name="article"
                                                       value="{{ $article->id }}"
                                                >
                                                <button type="submit"
                                                        class="inline-block p-2 cursor-pointer mx-2 border bg-[#e8f5e9] border-[#4caf50] rounded text-[#4caf50]"
                                                >لغو تایید
                                                </button>
                                            </form>

                                        @else
                                            <form class="inline-block"
                                                  action="{{ route('article.approve.article') }}"
                                                  method="POST"
                                            >
                                                @csrf
                                                <input type="hidden"
                                                       name="article"
                                                       value="{{ $article->id }}"
                                                >
                                                <button type="submit"
                                                        class="inline-block p-2 cursor-pointer mx-2 border bg-[#e8f5e9] border-[#4caf50] rounded text-[#4caf50]"
                                                >تایید
                                                </button>
                                            </form>
                                        @endif
                                    @endif

                                </td>
                            </tr>
                        @endforeach

                    @endif


                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

