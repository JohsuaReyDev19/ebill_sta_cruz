// DOM elements and selectors
const DOMstrings = {
  stepsBtnClass: 'multisteps-form__progress-btn',
  stepsBtns: document.querySelectorAll(`.multisteps-form__progress-btn`),
  stepsBar: document.querySelector('.multisteps-form__progress'),
  stepsForm: document.querySelector('.multisteps-form__form'),
  stepsFormTextareas: document.querySelectorAll('.multisteps-form__textarea'),
  stepFormPanelClass: 'multisteps-form__panel',
  stepFormPanels: document.querySelectorAll('.multisteps-form__panel'),
  stepPrevBtnClass: 'js-btn-prev',
  stepNextBtnClass: 'js-btn-next'
};

// Utility functions
const removeClasses = (elemSet, className) => {
  elemSet.forEach(elem => {
    elem.classList.remove(className);
  });
};

const findParent = (elem, parentClass) => {
  let currentNode = elem;
  while (!currentNode.classList.contains(parentClass)) {
    currentNode = currentNode.parentNode;
  }
  return currentNode;
};

const getActiveStep = elem => {
  return Array.from(DOMstrings.stepsBtns).indexOf(elem);
};

const setActiveStep = activeStepNum => {
  removeClasses(DOMstrings.stepsBtns, 'js-active');
  DOMstrings.stepsBtns.forEach((elem, index) => {
    if (index <= activeStepNum) {
      elem.classList.add('js-active');
    }
  });
};

const getActivePanel = () => {
  let activePanel;
  DOMstrings.stepFormPanels.forEach(elem => {
    if (elem.classList.contains('js-active')) {
      activePanel = elem;
    }
  });
  return activePanel;
};

const setActivePanel = activePanelNum => {
  removeClasses(DOMstrings.stepFormPanels, 'js-active');
  DOMstrings.stepFormPanels.forEach((elem, index) => {
    if (index === activePanelNum) {
      elem.classList.add('js-active');
      setFormHeight(elem);
    }
  });
};

const formHeight = activePanel => {
  const activePanelHeight = activePanel.offsetHeight;
  DOMstrings.stepsForm.style.height = `${activePanelHeight}px`;
};

const setFormHeight = () => {
  const activePanel = getActivePanel();
  formHeight(activePanel);
};

// Function to show SweetAlert2 warning message
const showWarningMessage2 = (message) => {
    Swal.fire({
        icon: 'warning',
        title: 'Oops...',
        text: message
    });
};

// Function to validate required fields in the active panel
const validateFieldsInPanel = (panel) => {
  const requiredFields = panel.querySelectorAll('[required]');
  let allFieldsAreValid = true; // Assume all fields are valid initially

  requiredFields.forEach(field => {
    field.classList.remove('is-invalid'); // Remove any previous 'is-invalid' class

    if (field.tagName === 'SELECT' && (field.value === '' || field.value === null)) {
      allFieldsAreValid = false;
      showWarningMessage2('Please fill-up the required fields.');
      field.classList.add('is-invalid'); // Add red border to indicate missing field
      return; // Stop checking further fields on the first invalid field
    } else if (field.tagName === 'INPUT' && field.value.trim() === '') {
      allFieldsAreValid = false;
      showWarningMessage2('Please fill-up the required fields.');
      field.classList.add('is-invalid'); // Add red border to indicate missing field
      return; // Stop checking further fields on the first invalid field
    } else if (field.tagName === 'TEXTAREA' && field.value.trim() === '') {
      allFieldsAreValid = false;
      showWarningMessage2('Please fill-up the required fields.');
      field.classList.add('is-invalid'); // Add red border to indicate missing field
      return; // Stop checking further fields on the first invalid field
    }
  });

  return allFieldsAreValid;
};

// Event listener for previous/next button clicks
DOMstrings.stepsForm.addEventListener('click', e => {
  const eventTarget = e.target;

  if (!(eventTarget.classList.contains(`${DOMstrings.stepPrevBtnClass}`) || eventTarget.classList.contains(`${DOMstrings.stepNextBtnClass}`))) {
    return;
  }

  const activePanel = findParent(eventTarget, `${DOMstrings.stepFormPanelClass}`);

  if (eventTarget.classList.contains(`${DOMstrings.stepNextBtnClass}`)) {
    if (!validateFieldsInPanel(activePanel)) {
      return; // Stop if fields are invalid
    }
  }

  let activePanelNum = Array.from(DOMstrings.stepFormPanels).indexOf(activePanel);

  if (eventTarget.classList.contains(`${DOMstrings.stepPrevBtnClass}`)) {
    activePanelNum--;
  } else {
    activePanelNum++;
  }

  setActiveStep(activePanelNum);
  setActivePanel(activePanelNum);
});

// Set form height on load and resize
window.addEventListener('load', setFormHeight, false);
window.addEventListener('resize', setFormHeight, false);

// Optional: Function to change animation (not needed if you want to keep the default)
const setAnimationType = newType => {
  DOMstrings.stepFormPanels.forEach(elem => {
    elem.dataset.animation = newType;
  });
};

// Optional: Selector for animation change
const animationSelect = document.querySelector('.pick-animation__select');
// Uncomment below if you want to enable animation change
// animationSelect.addEventListener('change', () => {
//   const newAnimationType = animationSelect.value;
//   setAnimationType(newAnimationType);
// });
