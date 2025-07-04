@extends('layouts.app')
@section('title', 'Configurações')
@section('content')
<div class="px-0 flex flex-1 justify-center py-5">
    <div class="layout-content-container flex flex-col max-w-[960px] flex-1">
        <div class="flex flex-wrap justify-between gap-3 p-4"><p
                class="text-[#111418] tracking-light text-[32px] font-bold leading-tight min-w-72">Essay Feedback</p>
        </div>
        <h2 class="text-[#111418] text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5">Overall
            Score</h2>
        <div class="flex flex-wrap gap-4 p-4">
            <div class="flex min-w-[158px] flex-1 flex-col gap-2 rounded-lg p-6 bg-[#f0f2f5]">
                <p class="text-[#111418] text-base font-medium leading-normal">Total Score</p>
                <p class="text-[#111418] tracking-light text-2xl font-bold leading-tight">840</p>
            </div>
        </div>
        <h2 class="text-[#111418] text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5">Detailed
            Feedback</h2>
        <div class="flex flex-col p-4 gap-3">
            <details class="flex flex-col rounded-lg border border-[#dbe0e6] bg-white px-[15px] py-[7px] group">
                <summary class="flex cursor-pointer items-center justify-between gap-6 py-2">
                    <p class="text-[#111418] text-sm font-medium leading-normal">Mastery of the Standard Written Form of
                        Portuguese</p>
                    <div class="text-[#111418] group-open:rotate-180" data-icon="CaretDown" data-size="20px"
                         data-weight="regular">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" fill="currentColor"
                             viewBox="0 0 256 256">
                            <path
                                d="M213.66,101.66l-80,80a8,8,0,0,1-11.32,0l-80-80A8,8,0,0,1,53.66,90.34L128,164.69l74.34-74.35a8,8,0,0,1,11.32,11.32Z"></path>
                        </svg>
                    </div>
                </summary>
                <p class="text-[#60758a] text-sm font-normal leading-normal pb-2"></p>
            </details>
            <details class="flex flex-col rounded-lg border border-[#dbe0e6] bg-white px-[15px] py-[7px] group">
                <summary class="flex cursor-pointer items-center justify-between gap-6 py-2">
                    <p class="text-[#111418] text-sm font-medium leading-normal">Understanding the Essay Theme</p>
                    <div class="text-[#111418] group-open:rotate-180" data-icon="CaretDown" data-size="20px"
                         data-weight="regular">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" fill="currentColor"
                             viewBox="0 0 256 256">
                            <path
                                d="M213.66,101.66l-80,80a8,8,0,0,1-11.32,0l-80-80A8,8,0,0,1,53.66,90.34L128,164.69l74.34-74.35a8,8,0,0,1,11.32,11.32Z"></path>
                        </svg>
                    </div>
                </summary>
                <p class="text-[#60758a] text-sm font-normal leading-normal pb-2"></p>
            </details>
            <details class="flex flex-col rounded-lg border border-[#dbe0e6] bg-white px-[15px] py-[7px] group">
                <summary class="flex cursor-pointer items-center justify-between gap-6 py-2">
                    <p class="text-[#111418] text-sm font-medium leading-normal">Argumentation and Persuasion</p>
                    <div class="text-[#111418] group-open:rotate-180" data-icon="CaretDown" data-size="20px"
                         data-weight="regular">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" fill="currentColor"
                             viewBox="0 0 256 256">
                            <path
                                d="M213.66,101.66l-80,80a8,8,0,0,1-11.32,0l-80-80A8,8,0,0,1,53.66,90.34L128,164.69l74.34-74.35a8,8,0,0,1,11.32,11.32Z"></path>
                        </svg>
                    </div>
                </summary>
                <p class="text-[#60758a] text-sm font-normal leading-normal pb-2"></p>
            </details>
            <details class="flex flex-col rounded-lg border border-[#dbe0e6] bg-white px-[15px] py-[7px] group">
                <summary class="flex cursor-pointer items-center justify-between gap-6 py-2">
                    <p class="text-[#111418] text-sm font-medium leading-normal">Textual Cohesion and Coherence</p>
                    <div class="text-[#111418] group-open:rotate-180" data-icon="CaretDown" data-size="20px"
                         data-weight="regular">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" fill="currentColor"
                             viewBox="0 0 256 256">
                            <path
                                d="M213.66,101.66l-80,80a8,8,0,0,1-11.32,0l-80-80A8,8,0,0,1,53.66,90.34L128,164.69l74.34-74.35a8,8,0,0,1,11.32,11.32Z"></path>
                        </svg>
                    </div>
                </summary>
                <p class="text-[#60758a] text-sm font-normal leading-normal pb-2"></p>
            </details>
            <details class="flex flex-col rounded-lg border border-[#dbe0e6] bg-white px-[15px] py-[7px] group">
                <summary class="flex cursor-pointer items-center justify-between gap-6 py-2">
                    <p class="text-[#111418] text-sm font-medium leading-normal">Proposal for Intervention</p>
                    <div class="text-[#111418] group-open:rotate-180" data-icon="CaretDown" data-size="20px"
                         data-weight="regular">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" fill="currentColor"
                             viewBox="0 0 256 256">
                            <path
                                d="M213.66,101.66l-80,80a8,8,0,0,1-11.32,0l-80-80A8,8,0,0,1,53.66,90.34L128,164.69l74.34-74.35a8,8,0,0,1,11.32,11.32Z"></path>
                        </svg>
                    </div>
                </summary>
                <p class="text-[#60758a] text-sm font-normal leading-normal pb-2"></p>
            </details>
        </div>
        <h2 class="text-[#111418] text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5">Suggestions
            for Improvement</h2>
        <p class="text-[#111418] text-base font-normal leading-normal pb-3 pt-1 px-4">
            Review the feedback provided in each criterion to identify areas for improvement. Focus on strengthening
            your argumentation, refining your writing style, and ensuring
            your proposal for intervention is detailed and feasible.
        </p>
    </div>
</div>
<footer class="flex justify-center">
    <div class="flex max-w-[960px] flex-1 flex-col">
        <footer class="flex flex-col gap-6 px-5 py-10 text-center @container">
            <div class="flex flex-wrap items-center justify-center gap-6 @[480px]:flex-row @[480px]:justify-around">
                <a class="text-[#60758a] text-base font-normal leading-normal min-w-40" href="#">Terms of Service</a>
                <a class="text-[#60758a] text-base font-normal leading-normal min-w-40" href="#">Privacy Policy</a>
                <a class="text-[#60758a] text-base font-normal leading-normal min-w-40" href="#">Contact Us</a>
            </div>
            <p class="text-[#60758a] text-base font-normal leading-normal">@2024 Essay Feedback. All rights
                reserved.</p>
        </footer>
    </div>
</footer>
@endsection
