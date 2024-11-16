@extends('layouts.user.index')

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Start::app-content -->
    <div class="main-content app-content">
        <div class="container-fluid">
            @include('partials.users.alert')
            <div id="savings-card-container" class="mt-5">
            </div>
        </div>
    </div>
<!-- End::app-content -->

@endsection

@section('scripts')

<script>

    const cardData = [
        {
            id: 1,
            name: 'High-Yield Savings Account (HYSA)',
            sub_name: 'Lorem ipsum dolor sit amet consectetur, adipisicing.',
            img: 'https://www.oneazcu.com/media/54nn41qg/propel-savings_500x500.png',
            btnText: 'Start Savings',
            modalId: 'modalHYSA', // Unique modal ID for each card
            questions: [
                {
                    question: 'What is your primary goal for this savings account?',
                    answers: [
                        'Build an emergency fund',
                        'Earn higher interest on savings',
                        'Save for future large purchases (e.g., home, car)',
                    ]
                },
                {
                    question: 'What is your expected contribution amount?',
                    answers: [
                        'Less than $500/month',
                        '$500 – $1,000/month',
                        'Over $1,000/month',
                    ]
                },
                {
                    question: 'How long do you plan to keep your savings in this account?',
                    answers: [
                        'Less than 1 year',
                        '1–3 years',
                        'Over 3 years',
                    ]
                },
                {
                    question: 'Do you need frequent access to the funds, or can they remain untouched?',
                    answers: [
                        'Frequent access needed',
                        'No access required for now',
                    ]
                },
                {
                    question: 'Would you like to reinvest interest into the account or withdraw it periodically?',
                    answers: [
                        'Reinvest interest',
                        'Withdraw interest periodically',
                    ]
                }
            ]
        },
        {
            id: 2,
            name: 'Cash Interest Account',
            sub_name: 'Lorem ipsum dolor sit amet consectetur, adipisicing.',
            img: 'https://www.oneazcu.com/media/zpfjqqui/no-fees_500x500.webp',
            btnText: 'Start Savings',
            modalId: 'modalCashInterest',
            questions: [
                {
                    question: 'What is the purpose of this cash account?',
                    answers: [
                        'Maintain liquidity with interest growth',
                        'Short-term cash management for upcoming expenses',
                        'Long-term capital preservation with flexible access',
                    ]
                },
                {
                    question: 'How often do you plan to deposit funds into this account?',
                    answers: [
                        'Weekly',
                        'Monthly',
                        'Irregularly',
                    ]
                },
                {
                    question: 'Do you need frequent access to these funds?',
                    answers: [
                        'Yes, I’ll need regular access',
                        'No, I can leave the funds untouched',
                    ]
                },
                {
                    question: 'Would you like a portion of this account to be allocated to higher interest products?',
                    answers: [
                        'Yes, maximize growth on a portion of funds',
                        'No, keep everything liquid',
                    ]
                }
            ]
        },
        {
            id: 3,
            name: 'Tax-Free Savings Account',
            sub_name: 'Lorem ipsum dolor sit amet consectetur, adipisicing.',
            img: 'https://www.oneazcu.com/media/a0jeky3a/cash_2024_500x500.webp',
            btnText: 'Start Savings',
            modalId: 'modalTaxFree',
            questions: [
                {
                    question: 'What is your primary goal for this tax-free savings account?',
                    answers: [
                        'Save for education or long-term projects',
                        'Maximize tax-free growth',
                        'Build long-term savings for retirement or specific milestones',
                    ]
                },
                {
                    question: 'How much do you plan to contribute each year?',
                    answers: [
                        'Less than $5,000',
                        '$5,000 – $10,000',
                        'Over $10,000',
                    ]
                },
                {
                    question: 'What is your expected time horizon for this account?',
                    answers: [
                        'Less than 5 years',
                        '5–10 years',
                        'Over 10 years',
                    ]
                },
                {
                    question: 'Do you prefer to reinvest all earnings into the account or withdraw them as they accumulate?',
                    answers: [
                        'Reinvest all earnings',
                        'Withdraw earnings periodically',
                    ]
                }
            ]
        },
        {
            id: 4,
            name: 'First Home Savings Account',
            sub_name: 'Lorem ipsum dolor sit amet consectetur, adipisicing.',
            img: 'https://www.oneazcu.com/media/3junkeko/transfer-money-500x500.webp',
            btnText: 'Start Savings',
            modalId: 'modalFirstHome',
            questions: [
                {
                    question: 'When do you plan to purchase your first home?',
                    answers: [
                        'Within 1 year',
                        '1–3 years',
                        'Over 3 years',
                    ]
                },
                {
                    question: 'How much do you plan to save for a home down payment?',
                    answers: [
                        'Less than $50,000',
                        '$50,000 – $100,000',
                        'Over $100,000',
                    ]
                },
                {
                    question: 'How much do you plan to contribute monthly toward this goal?',
                    answers: [
                        'Less than $500',
                        '$500 – $1,000',
                        'Over $1,000',
                    ]
                },
                {
                    question: 'Do you need to access these funds before reaching your savings goal?',
                    answers: [
                        'Yes, I may need access',
                        'No, I plan to leave the funds untouched',
                    ]
                },
                {
                    question: 'Would you like financial advice on home-buying incentives and tax benefits?',
                    answers: [
                        'Yes',
                        'No',
                    ]
                }
            ]
        },
        {
            id: 5,
            name: 'Corporate Accounts',
            sub_name: 'Lorem ipsum dolor sit amet consectetur, adipisicing.',
            img: 'https://www.oneazcu.com/media/0axfwoe2/lock-security-500x500.webp',
            btnText: 'Start Savings',
            modalId: 'modalCorporate',
            questions: [
                {
                    question: 'What is the primary purpose of this corporate account?',
                    answers: [
                        'Cash flow management for operations',
                        'Capital preservation for business investments',
                        'Employee benefit funding (e.g., 401(k) or pensions)',
                    ]
                },
                {
                    question: 'How much do you plan to deposit into this account monthly?',
                    answers: [
                        'Less than $10,000',
                        '$10,000 – $50,000',
                        'Over $50,000',
                    ]
                },
                {
                    question: 'Do you require frequent access to corporate funds?',
                    answers: [
                        'Yes, for daily operations',
                        'No, funds can remain untouched',
                    ]
                },
                {
                    question: 'Would you like a portion of corporate funds to be invested for long-term growth?',
                    answers: [
                        'Yes, allocate a portion to investments',
                        'No, keep all funds in cash reserves',
                    ]
                }
            ]
        },
        {
            id: 6,
            name: 'Retirement Accounts (Roth IRA, SEP IRA, Traditional IRA)',
            sub_name: 'Lorem ipsum dolor sit amet consectetur, adipisicing.',
            img: 'https://www.oneazcu.com/media/xf5p3zer/click_desktop_500x500.webp',
            btnText: 'Start Savings',
            modalId: 'modalRetirement',
            questions: [
                {
                    question: 'What is your goal with this Roth IRA?',
                    answers: [
                        'Tax-free growth for retirement',
                        'Maximize savings for long-term retirement needs',
                    ]
                },
                {
                    question: 'How much do you plan to contribute each year?',
                    answers: [
                        'Less than $6,500',
                        '$6,500 – $15,000 (catch-up contributions for age 50+)',
                    ]
                },
                {
                    question: 'When do you expect to start withdrawing from the account?',
                    answers: [
                        'Before age 59 ½',
                        'After age 59 ½',
                    ]
                },
                {
                    question: 'Would you prefer automatic monthly or annual contributions?',
                    answers: [
                        'Monthly',
                        'Annually',
                    ]
                }
            ]
        }
    ];

    $(document).ready(function () {
    const routeId = window.location.pathname.split('/')[3]; // Extract the route ID from URL
    const selectedCard = cardData.find(card => card.id == routeId); // Find the card data based on the route ID

    if (selectedCard) {
        // Create the card content dynamically
        let cardHtml = `
            <div class="card mx-auto px-3 py-3" style="max-width:850px;">
                <div class="">
                    <div class="my-4">
                        <h5 class="modal-title text-center fw-bold">${selectedCard.name}</h5>
                        <p class="modal-title text-center text-muted fs-12 mx-auto mt-2" style="max-width: 300px;">${selectedCard.sub_name}</p>
                    </div>

                    <div class="progress-container mx-auto" style="background: rgba(0, 0, 0, 0.03); height: 6px; width: 100%; position: relative; top: 0; left: 0; max-width: 550px;">
                        <div class="bg-primary rounded" id="progress-bar-${selectedCard.modalId}" style="height: 100%; width: 0%; transition: width 0.3s;"></div>
                    </div>

                    <form id="savings-form" class="mx-auto" method="POST" action="{{ route('savings.store') }}" style="max-width: 550px;">
                        @csrf
                        <input type="hidden" name="plan_id" value=""> <!-- Hidden plan_id -->
                        <input type="hidden" name="plan_info" value=""> <!-- Hidden plan_info -->
                        <div id="question-container-${selectedCard.modalId}">
            `;

        // Create an array of screen names for navigation
        const screens = selectedCard.questions.map((_, index) => `screen-${index}`);
        screens.push('summary-screen'); // Add the summary screen as the last screen
        let currentIndex = 0; // Start with the first question

        // Store selected answers
        let selectedAnswers = {};

        // Create a question container for each question
        selectedCard.questions.forEach((q, index) => {
            const questionId = `question-${index}`; // Generate a unique ID based on index

            cardHtml += `
                <div class="${screens[index]} question-card" style="display: ${index === 0 ? 'block' : 'none'};">
                    <div class="my-2">
                        <label class="text-left fs-13 fw-bold my-3">${q.question}</label>
                        <div class="error-message fw-bold fs-12 mb-3" id="error-${questionId}" style="display: none; color: red; text-align: center;">Please select an answer.</div>
                        <div class="form-check-group"> 
                            ${q.answers.map((answer, aIndex) => `
                                <div class="form-check mb-2" style="border: 1px solid rgba(0, 0, 0, 0.1); padding: 20px 0px; border-radius: 15px; cursor: pointer;">
                                    <input class="form-check-input mx-3" type="radio" name="answer-${questionId}" value="${answer}" id="radio-${questionId}-${aIndex}">
                                    <label class="form-check-label mx-3" for="radio-${questionId}-${aIndex}">
                                        ${answer}
                                    </label>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                </div>
            `;
        });

        // Add the navigation buttons
        cardHtml += `
                    </div>
                    <div class="d-flex justify-content-between mx-auto my-4" style="max-width: 550px;">
                        <button type="button" class="btn btn-dark-transparent border-0" id="prevButton-${selectedCard.modalId}" disabled>
                            <i class="fe fe-arrow-left"></i> Previous
                        </button>
                        <button type="button" class="btn btn-primary-transparent px-4" id="nextButton-${selectedCard.modalId}">
                            Next <i class="fe fe-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    `;

        // Append the dynamically generated HTML to the savings card container
        $('#savings-card-container').html(cardHtml);

        // Show the current question based on index
        function showQuestion(index) {
            // Hide all screens first
            $('.question-card').hide();

            if (index === screens.length - 1) {
                // If the current index is the last screen (summary screen), display summary
                showSummaryScreen();
            } else {
                // Show the current screen
                $(`.${screens[index]}`).show();
            }

            // Update the progress bar width based on the current screen index
            const progressBar = $(`#progress-bar-${selectedCard.modalId}`);
            const progressPercentage = (index / (screens.length - 1)) * 100;
            progressBar.css('width', `${progressPercentage}%`);

            // Disable Previous button on the first screen or summary screen
            $(`#prevButton-${selectedCard.modalId}`).prop('disabled', index === 0 || index === screens.length - 1);

            // Change the "Next" button to "Submit" on the summary screen
            if (index === screens.length - 1) {
                $(`#nextButton-${selectedCard.modalId}`).text('Submit').off('click').on('click', function () {
                    submitForm(); // Submit the form when clicking submit
                });
            } else {
                // Set "Next" button back to "Next" on non-last screens
                $(`#nextButton-${selectedCard.modalId}`).text('Next').off('click').on('click', function () {
                    validateAndProceed(); // Validate and proceed to the next question
                });
            }

            // Update the button text based on index
            $(`#nextButton-${selectedCard.modalId}`).html(
                index === screens.length - 1 
                    ? 'Submit <i class="fe fe-check"></i>' 
                    : 'Next <i class="fe fe-arrow-right"></i>'
            );
        }

        // Display the first question on load
        showQuestion(currentIndex);

        // Validate the current screen before moving to the next
        function validateAndProceed() {
            const currentQuestion = selectedCard.questions[currentIndex];
            const questionId = `question-${currentIndex}`;
            const selectedAnswer = $(`input[name="answer-${questionId}"]:checked`).val();

            if (!selectedAnswer) {
                // Show validation error
                $(`#error-${questionId}`).show();
            } else {
                // Hide error message if an answer is selected
                $(`#error-${questionId}`).hide();
                selectedAnswers[questionId] = selectedAnswer; // Store the selected answer

                if (currentIndex < screens.length - 1) {
                    currentIndex++;
                    showQuestion(currentIndex);
                } else {
                    // If it's the last screen, trigger the submission
                    submitForm();
                }
            }
        }

        // Show summary screen
        function showSummaryScreen() {
            let summaryHtml = `
                <div class="question-card">
                    <h5 class="text-center fw-bold my-4">Summary</h5>
                    <div class="summary-container mx-auto" style="max-width: 550px;">
                        ${selectedCard.questions.map((q, index) => `
                            <div class="summary-item my-3">
                                <p class="text-muted fs-12">${q.question}</p>
                                <h6 class="fw-bold fs-13">${selectedAnswers[`question-${index}`] || 'No answer selected'}</h6>
                            </div>
                        `).join('')}
                    </div>
                </div>
            `;

            // Replace the question container content with the summary
            $(`#question-container-${selectedCard.modalId}`).html(summaryHtml);
        }

        // Previous button functionality
        $(`#prevButton-${selectedCard.modalId}`).click(function () {
            if (currentIndex > 0) {
                currentIndex--;
                showQuestion(currentIndex);
            }
        });

        // Submit the form
        function submitForm() {
            // Append the selected answers to the form as JSON
            const planInfo = JSON.stringify(selectedAnswers);

            // Add the plan_id and plan_info to the form and submit it
            $('input[name="plan_id"]').val(routeId); // You can use any other ID value as needed
            $('input[name="plan_info"]').val(planInfo); // Add the plan_info (selected answers)

            // Submit the form
            $('#savings-form').submit(); // Submit the form to the server
        }

        // Make the entire form-check div clickable
        $(document).on('click', '.form-check', function () {
            const radioInput = $(this).find('input[type="radio"]');
            radioInput.prop('checked', true); // Select the radio button
            radioInput.trigger('change'); // Trigger change event in case there is a listener
        });
    }
});


</script>

@endsection