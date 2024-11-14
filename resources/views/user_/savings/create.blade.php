@extends('layouts.user.index')

@section('content')

<style>
    select {
        appearance: auto !important;
        -webkit-appearance: auto;
        -moz-appearance: auto;
    }
    select:focus {
        appearance: none;
    }
</style>

<!-- Start::app-content -->
    <div class="main-content app-content">
        <div class="container-fluid">
            <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div>
                    <h1 class="page-title fw-medium fs-18 mb-2">Savings</h1>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0);">
                            Dashboard
                            </a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page"><a href="javascript:void(0);">Savings</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Plans</li>
                    </ol>
                </div>
            </div>

        </div>

        <div class="row mx-2 no-gutters" id="cardContainer">
             <!-- :::Content goes here -->
        </div>

        <!-- <div class="modal fade" id="modalHYSA" tabindex="-1" role="dialog" aria-labelledby="modalHYSALabel" aria-hidden="true">
            <div class="modal-dialog" role="document" style="max-width: 700px;">
                <div class="modal-content">
                    <div class="my-4">
                        <h5 class="modal-title text-center fw-bold" id="nairaDepositModalLabel">High-Yield Savings Account (HYSA)</h5>
                    </div>

                    <div id="screen-holder">
                        
                    </div>
                </div>
            </div>
        </div> -->


    </div>
<!-- End::app-content -->

@endsection

@section('scripts')

<script>

// $(document).ready(function() {
    
//     const cardData = [
//         {
//             name: 'High-Yield Savings Account (HYSA)',
//             img: 'https://www.oneazcu.com/media/54nn41qg/propel-savings_500x500.png',
//             btnText: 'Start Savings',
//             modalId: 'modalHYSA', // Unique modal ID for each card
//             questions: [
//                 {
//                     question: 'What is your primary goal for this savings account?',
//                     answers: [
//                         'Build an emergency fund',
//                         'Earn higher interest on savings',
//                         'Save for future large purchases (e.g., home, car)',
//                     ]
//                 },
//                 {
//                     question: 'What is your expected contribution amount?',
//                     answers: [
//                         'Less than $500/month',
//                         '$500 – $1,000/month',
//                         'Over $1,000/month',
//                     ]
//                 },
//                 {
//                     question: 'How long do you plan to keep your savings in this account?',
//                     answers: [
//                         'Less than 1 year',
//                         '1–3 years',
//                         'Over 3 years',
//                     ]
//                 },
//                 {
//                     question: 'Do you need frequent access to the funds, or can they remain untouched?',
//                     answers: [
//                         'Frequent access needed',
//                         'No access required for now',
//                     ]
//                 },
//                 {
//                     question: 'Would you like to reinvest interest into the account or withdraw it periodically?',
//                     answers: [
//                         'Reinvest interest',
//                         'Withdraw interest periodically',
//                     ]
//                 }
//             ]
//         },
//         {
//             name: 'Cash Interest Account',
//             img: 'https://www.oneazcu.com/media/zpfjqqui/no-fees_500x500.webp',
//             btnText: 'Start Savings',
//             modalId: 'modalCashInterest',
//             questions: [
//                 {
//                     question: 'What is the purpose of this cash account?',
//                     answers: [
//                         'Maintain liquidity with interest growth',
//                         'Short-term cash management for upcoming expenses',
//                         'Long-term capital preservation with flexible access',
//                     ]
//                 },
//                 {
//                     question: 'How often do you plan to deposit funds into this account?',
//                     answers: [
//                         'Weekly',
//                         'Monthly',
//                         'Irregularly',
//                     ]
//                 },
//                 {
//                     question: 'Do you need frequent access to these funds?',
//                     answers: [
//                         'Yes, I’ll need regular access',
//                         'No, I can leave the funds untouched',
//                     ]
//                 },
//                 {
//                     question: 'Would you like a portion of this account to be allocated to higher interest products?',
//                     answers: [
//                         'Yes, maximize growth on a portion of funds',
//                         'No, keep everything liquid',
//                     ]
//                 }
//             ]
//         },
//         {
//             name: 'Tax-Free Savings Account',
//             img: 'https://www.oneazcu.com/media/a0jeky3a/cash_2024_500x500.webp',
//             btnText: 'Start Savings',
//             modalId: 'modalTaxFree',
//             questions: [
//                 {
//                     question: 'What is your primary goal for this tax-free savings account?',
//                     answers: [
//                         'Save for education or long-term projects',
//                         'Maximize tax-free growth',
//                         'Build long-term savings for retirement or specific milestones',
//                     ]
//                 },
//                 {
//                     question: 'How much do you plan to contribute each year?',
//                     answers: [
//                         'Less than $5,000',
//                         '$5,000 – $10,000',
//                         'Over $10,000',
//                     ]
//                 },
//                 {
//                     question: 'What is your expected time horizon for this account?',
//                     answers: [
//                         'Less than 5 years',
//                         '5–10 years',
//                         'Over 10 years',
//                     ]
//                 },
//                 {
//                     question: 'Do you prefer to reinvest all earnings into the account or withdraw them as they accumulate?',
//                     answers: [
//                         'Reinvest all earnings',
//                         'Withdraw earnings periodically',
//                     ]
//                 }
//             ]
//         },
//         {
//             name: 'First Home Savings Account',
//             img: 'https://www.oneazcu.com/media/3junkeko/transfer-money-500x500.webp',
//             btnText: 'Start Savings',
//             modalId: 'modalFirstHome',
//             questions: [
//                 {
//                     question: 'When do you plan to purchase your first home?',
//                     answers: [
//                         'Within 1 year',
//                         '1–3 years',
//                         'Over 3 years',
//                     ]
//                 },
//                 {
//                     question: 'How much do you plan to save for a home down payment?',
//                     answers: [
//                         'Less than $50,000',
//                         '$50,000 – $100,000',
//                         'Over $100,000',
//                     ]
//                 },
//                 {
//                     question: 'How much do you plan to contribute monthly toward this goal?',
//                     answers: [
//                         'Less than $500',
//                         '$500 – $1,000',
//                         'Over $1,000',
//                     ]
//                 },
//                 {
//                     question: 'Do you need to access these funds before reaching your savings goal?',
//                     answers: [
//                         'Yes, I may need access',
//                         'No, I plan to leave the funds untouched',
//                     ]
//                 },
//                 {
//                     question: 'Would you like financial advice on home-buying incentives and tax benefits?',
//                     answers: [
//                         'Yes',
//                         'No',
//                     ]
//                 }
//             ]
//         },
//         {
//             name: 'Corporate Accounts',
//             img: 'https://www.oneazcu.com/media/0axfwoe2/lock-security-500x500.webp',
//             btnText: 'Start Savings',
//             modalId: 'modalCorporate',
//             questions: [
//                 {
//                     question: 'What is the primary purpose of this corporate account?',
//                     answers: [
//                         'Cash flow management for operations',
//                         'Capital preservation for business investments',
//                         'Employee benefit funding (e.g., 401(k) or pensions)',
//                     ]
//                 },
//                 {
//                     question: 'How much do you plan to deposit into this account monthly?',
//                     answers: [
//                         'Less than $10,000',
//                         '$10,000 – $50,000',
//                         'Over $50,000',
//                     ]
//                 },
//                 {
//                     question: 'Do you require frequent access to corporate funds?',
//                     answers: [
//                         'Yes, for daily operations',
//                         'No, funds can remain untouched',
//                     ]
//                 },
//                 {
//                     question: 'Would you like a portion of corporate funds to be invested for long-term growth?',
//                     answers: [
//                         'Yes, allocate a portion to investments',
//                         'No, keep all funds in cash reserves',
//                     ]
//                 }
//             ]
//         },
//         {
//             name: 'Retirement Accounts (Roth IRA, SEP IRA, Traditional IRA)',
//             img: 'https://www.oneazcu.com/media/xf5p3zer/click_desktop_500x500.webp',
//             btnText: 'Start Savings',
//             modalId: 'modalRetirement',
//             questions: [
//                 {
//                     question: 'What is your goal with this Roth IRA?',
//                     answers: [
//                         'Tax-free growth for retirement',
//                         'Maximize savings for long-term retirement needs',
//                     ]
//                 },
//                 {
//                     question: 'How much do you plan to contribute each year?',
//                     answers: [
//                         'Less than $6,500',
//                         '$6,500 – $15,000 (catch-up contributions for age 50+)',
//                     ]
//                 },
//                 {
//                     question: 'When do you expect to start withdrawing from the account?',
//                     answers: [
//                         'Before age 59 ½',
//                         'After age 59 ½',
//                     ]
//                 },
//                 {
//                     question: 'Would you prefer automatic monthly or annual contributions?',
//                     answers: [
//                         'Monthly',
//                         'Annually',
//                     ]
//                 }
//             ]
//         }
//     ];

//     // Generate cards dynamically
//     cardData.forEach((card, index) => {
//         const cardHtml = 
//             `<div class="col-md-4 col-sm-12">
//                 <div class="card py-2">
//                     <div class="my-4 px-auto py-4 text-center">
//                         <span class="avatar avatar-xl bg-primary-transparent me-2 shadow-avatar mb-3">
//                             <img class="p-1" src="${card.img}" alt="">
//                         </span>
//                         <h5 class="fw-medium fs-14 mt-2 mx-2">${card.name}</h5>
//                     </div>
//                     <div class="text-center px-auto">
//                         <button class="btn btn-primary-transparent px-4 fs-12 open-modal-btn" 
//                                 data-index="${index}" 
//                                 data-toggle="modal" 
//                                 data-target="#${card.modalId}">
//                             ${card.btnText} <i class="fe fe-plus me-2"></i>
//                         </button>
//                     </div>
//                 </div>
//             </div>`;
        
//         // Append card to the container
//         $('#cardContainer').append(cardHtml);

//         // Create modal dynamically for each card
//         const modalHtml = `
//             <div class="modal fade" id="${card.modalId}" tabindex="-1" role="dialog" aria-labelledby="${card.modalId}Label" aria-hidden="true">
//                 <div class="modal-dialog" role="document" style="max-width: 700px;">
//                     <div class="modal-content">
//                         <div class="my-4">
//                             <h5 class="modal-title text-center fw-bold" id="${card.modalId}Label">${card.name}</h5>
//                         </div>

//                         <div class="fw-bold fs-18" id="back-arrow" style="position: absolute; top: 22px; right: 20px; cursor: pointer;" data-bs-dismiss="modal">
//                             <i class="fe fe-x  me-2"></i>
//                         </div>

//                         <div id="screen-holder-${card.modalId}">
//                             <!-- Questions will be dynamically added here -->
//                         </div>

//                         <div class="mx-auto">
//                             <div class="d-flex justify-content-between my-4">
//                                 <button type="button" class="btn btn-primary-transparent px-4" id="nextScreenButton">Start Savings</button>
//                             </div>
//                         </div>
//                     </div>
//                 </div>
//             </div>`;
//         // Append modal to the body
//         $('body').append(modalHtml);
//     });

//     // Handle modal opening and populate content based on selected card
//     $('.open-modal-btn').click(function() {
//         const cardIndex = $(this).data('index');
//         const selectedCard = cardData[cardIndex];
        
//         // Set modal title dynamically (already done above)
//         const modalId = selectedCard.modalId;
//         const modalLabelId = `${modalId}Label`;

//         // Clear previous questions
//         $(`#screen-holder-${modalId}`).empty();

//         // Populate modal with dynamic questions and answers
//         selectedCard.questions.forEach((item, qIndex) => {
//             const questionHtml = `
//                 <div class="mx-auto" style="max-width: 550px;">
//                     <div class="row d-flex justify-content-center mx-auto">
//                         <div class="col-xl-12 my-2">
//                             <label class="text-left fs-13 fw-bold my-2">${item.question}</label>
//                             <div class="form-check-group"> 
//                                 ${item.answers.map(answer => `
//                                     <div class="form-check">
//                                         <input class="form-check-input" type="checkbox" value="${answer}" id="checkbox-${qIndex}-${answer}">
//                                         <label class="form-check-label" for="checkbox-${qIndex}-${answer}">
//                                             ${answer}
//                                         </label>
//                                     </div>
//                                 `).join('')}
//                             </div>
//                         </div>
//                     </div>
//                 </div>`;
            
//             $(`#screen-holder-${modalId}`).append(questionHtml);
//         });


//         // Show modal
//         $(`#${modalId}`).modal('show');
//     });

//     // Handle submit button click (just an example, you can replace this with your own logic)
//     $(document).on('click', '.submitButton', function() {
//         alert('Form submitted!');
//         // You can add the form submission logic here
//         $('.modal').modal('hide'); // Close modal after submit
//     });
// });


$(document).ready(function() {
    const cardData = [
        {
            name: 'High-Yield Savings Account (HYSA)',
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
            name: 'Cash Interest Account',
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
            name: 'Tax-Free Savings Account',
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
            name: 'First Home Savings Account',
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
            name: 'Corporate Accounts',
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
            name: 'Retirement Accounts (Roth IRA, SEP IRA, Traditional IRA)',
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

    // Generate cards dynamically
    cardData.forEach((card, index) => {
        const cardHtml = 
            `<div class="col-md-4 col-sm-12">
                <div class="card py-2">
                    <div class="my-4 px-auto py-4 text-center">
                        <span class="avatar avatar-xl bg-primary-transparent me-2 shadow-avatar mb-3">
                            <img class="p-1" src="${card.img}" alt="">
                        </span>
                        <h5 class="fw-medium fs-14 mt-2 mx-2">${card.name}</h5>
                    </div>
                    <div class="text-center px-auto">
                        <button class="btn btn-primary-transparent px-4 fs-12 open-modal-btn" 
                                data-index="${index}" 
                                data-toggle="modal" 
                                data-target="#${card.modalId}">
                            ${card.btnText} <i class="fe fe-plus me-2"></i>
                        </button>
                    </div>
                </div>
            </div>`;
        
        // Append card to the container
        $('#cardContainer').append(cardHtml);

        // Create modal dynamically for each card
        const modalHtml = `
            <div class="modal fade" id="${card.modalId}" tabindex="-1" role="dialog" aria-labelledby="${card.modalId}Label" aria-hidden="true">
                <div class="modal-dialog" role="document" style="max-width: 700px;">
                    <div class="modal-content">
                        <div class="row d-flex justify-content-center mx-auto">
                            <div class="my-4">
                                <h5 class="modal-title text-center fw-bold" id="${card.modalId}Label">${card.name}</h5>
                            </div>

                            <div class="fw-bold fs-18" id="back-arrow" style="position: absolute; top: 22px; right: -20px; cursor: pointer;" data-bs-dismiss="modal">
                                <i class="fe fe-x me-2"></i>
                            </div>

                            <div id="question-container-${card.modalId}" class="mx-auto" style="max-width: 550px;">
                                <!-- Dynamic Question Content -->
                            </div>

                            <div class="d-flex justify-content-between mx-auto my-4" style="max-width: 550px;">
                                <button type="button" class="btn btn-dark-transparent px-4" id="prevButton-${card.modalId}" >
                                    <i class="fe fe-arrow-left"></i> Previous
                                </button>
                                <button type="button" class="btn btn-dark-transparent px-4" id="nextButton-${card.modalId}">
                                    Next <i class="fe fe-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>`;
        
        // Append modal to the body
        $('body').append(modalHtml);
    });

    // Handle modal opening and populate content based on selected card
    $('.open-modal-btn').click(function() {
        const cardIndex = $(this).data('index');
        const selectedCard = cardData[cardIndex];
        const modalId = selectedCard.modalId;
        let currentQuestionIndex = 0;
        const answers = [];

        // Function to update the question screen
        function updateQuestion() {
            const questionContainer = $(`#question-container-${modalId}`);
            const questionData = selectedCard.questions[currentQuestionIndex];
            
            questionContainer.html(`
                <div class="row d-flex justify-content-center mx-auto">
                    <div class="col-xl-12 my-2">
                        <label class="text-left fs-13 fw-bold my-3">${questionData.question}</label>
                        <div class="form-check-group"> 
                            ${questionData.answers.map((answer, aIndex) => `
                                <div class="form-check mb-2" style="border: 1px solid rgba(0, 0, 0, 0.1); padding: 20px 0px; border-radius: 15px; cursor: pointer;">
                                    <input class="form-check-input mx-3" type="radio" name="answer-${currentQuestionIndex}" value="${answer}" id="radio-${currentQuestionIndex}-${aIndex}">
                                    <label class="form-check-label mx-3" for="radio-${currentQuestionIndex}-${aIndex}">
                                        ${answer}
                                    </label>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                </div>
            `);

            // Update button visibility and state
            // $(`#prevButton-${modalId}`).prop('disabled', currentQuestionIndex === 0);
            $(`#nextButton-${modalId}`).html(
                currentQuestionIndex === selectedCard.questions.length - 1 
                ? 'Submit <i class="fe fe-check"></i>' 
                : 'Next <i class="fe fe-arrow-right"></i>'
            );
        }

        // Initialize the first question
        updateQuestion();

        // Handle Next button click
        $(`#nextButton-${modalId}`).off('click').on('click', function() {
            const selectedOption = $(`input[name="answer-${currentQuestionIndex}"]:checked`).val();
            
            // Store the selected answer
            if (selectedOption) {
                answers[currentQuestionIndex] = selectedOption;

                if (currentQuestionIndex < selectedCard.questions.length - 1) {
                    currentQuestionIndex++;
                    updateQuestion();
                } else {
                    // Form submission with tracked answers
                    console.log('Submitted Answers:', answers);
                    alert('Form submitted!');
                    $(`#${modalId}`).modal('hide');
                }
            } else {
                alert('Please select an answer before proceeding.');
            }
        });

        // Handle Previous button click
        $(`#prevButton-${modalId}`).off('click').on('click', function() {
            if (currentQuestionIndex > 0) {
                currentQuestionIndex--;
                updateQuestion();
            }
        });

        // Show modal
        $(`#${modalId}`).modal('show');
    });
});


</script>

@endsection