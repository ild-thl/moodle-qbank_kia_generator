const init = (Y, courseid) => {
    document.querySelectorAll('.qbank_kia_generator-question .qbank_kia_generator-delete').forEach(button => {
        const confirmMessage = M.util.get_string('confirmdelete_question', 'qbank_kia_generator');
        button.addEventListener('click', e => {
            if (confirm(confirmMessage)) {
                removeQuestion(e.target.closest('.qbank_kia_generator-question'))
            }
        })
    })

    document.querySelector('#addToQBank').addEventListener('click', async e => {
        const waitMessage = M.util.get_string('wait', 'qbank_kia_generator');
        e.target.style.opacity = '0.5'
        e.target.value = waitMessage
        e.target.style.pointerEvents = 'none'
        
        const questions = buildQuestionObj()

        const apiUrl = M.cfg.wwwroot + '/question/bank/kia_generator/classes/api/question.php';
        console.log(apiUrl)
        const response = await fetch(apiUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(questions)
        })

        if (!response.ok) {
            console.error('Request error:', response.status, response.statusText)
            return
        }
        const data = await response.json()
        //console.log('Server response:', data)
        //alert('debug');

        window.location.href = M.cfg.wwwroot + `/question/edit.php?courseid=${courseid}`
    })

    document.querySelectorAll('.qbank_kia_generator-markCorrectButton').forEach(button => {
        button.addEventListener('click', (e) => {
            // If the AI didn't mark a correct answer for this question, this will fail
            // let's just catch it and ignore that
            try {
                e.target.closest('.qbank_kia_generator-text-container').querySelector('.qbank_kia_generator-correct').classList.remove('qbank_kia_generator-correct')
            } catch (e) {}
            e.target.parentElement.querySelector('input').classList.add('qbank_kia_generator-correct')
        })
    })
}

const buildQuestionObj = () => {
    let questions = {'questions': {}}
    document.querySelectorAll('.qbank_kia_generator-question').forEach(questionElem => {
        let answers = {}
        let correct = 'A';
        questionElem.querySelectorAll('input').forEach(answer => {
            if (answer.classList.contains('qbank_kia_generator-correct')) {
                correct = answer.dataset.qid
            }
            answers[answer.dataset.qid] = answer.value.trim()
        })
        questions['questions'][questionElem.querySelector('textarea').value] = {}
        questions['questions'][questionElem.querySelector('textarea').value]['answers'] = answers
        questions['questions'][questionElem.querySelector('textarea').value]['correct'] = correct
    })
    questions['courseid'] = document.querySelector('#courseid').value;
    questions['qtype'] = document.querySelector('#qtype').value;
    questions['categoryid'] = document.querySelector('#categoryid').value;

    return questions
}

const removeQuestion = (elem) => {
    elem.style.opacity = '0'
    elem.style.maxHeight = elem.clientHeight + 'px'
    window.setTimeout(() => {

        elem.style.maxHeight = '0px'
        elem.style.padding = '0'
        elem.style.marginTop = '-1rem'

        window.setTimeout(() => {
            elem.remove()
        }, 400)

    }, 150)
}