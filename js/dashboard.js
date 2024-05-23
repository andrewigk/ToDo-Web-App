    // grab entire form
const form = document.getElementById("taskForm");

// grab each form input
const taskName = document.getElementById("taskName");
const taskTag = document.getElementById("tag");
const taskDescription = document.getElementById("description");
const taskContainer = document.querySelectorAll(".newTask");

// create error message element for each input and insert it into DOM
const formTextInputs = document.querySelectorAll(".textfield2");

let taskNameError = document.createElement("p");
taskNameError.setAttribute("class", "warning2");
formTextInputs[0].append(taskNameError);

let taskTagError = document.createElement("p");
taskTagError.setAttribute("class", "warning2");
formTextInputs[1].append(taskTagError);

let taskDescriptionError = document.createElement("p");
taskDescriptionError.setAttribute("class", "warning2");
formTextInputs[2].append(taskDescriptionError);

let submitError = document.createElement('p');
submitError.setAttribute("class", "warning2");
taskContainer[0].append(submitError);

// Default error message is blank
const defaultErrorMessage = "";

// Add event listeners to all inputs so they constantly update

taskName.addEventListener("input", validateName);
taskTag.addEventListener("input", validateTag);
taskDescription.addEventListener("input", validateDescription);


// Validate function calls other validate functions, and only returns true 
function validate() {
    let validated = false;

    if (validateName() === defaultErrorMessage &&  validateTag() === defaultErrorMessage && validateDescription() === defaultErrorMessage ) {
        submitError.textContent = defaultErrorMessage;
        validated = true;
    }
    else {
        let submitErrorMsg="X One or more fields are invalid.";
        submitError.textContent=submitErrorMsg;
        validated = false;
    }

    return validated;
}

function validateName() {
    let name = taskName.value;
    let error;

    if (name.length >= 50) {
        error = "Task name must be less than 50 characters."
    } else if(name === "") {
        error = "Task name cannot be empty."
    } else {
        error = defaultErrorMessage;
    }

    taskNameError.textContent = error;
    return error;
}

function validateTag() {
    let tag = taskTag.value;
    let error;

    if (tag.length >= 50) {
        error = "Tag must be less than 50 characters."
    } else {
        error = defaultErrorMessage;
    }

    taskTagError.textContent = error;
    return error;
}

function validateDescription() {
    let desc = taskDescription.value;
    let error;

    if (desc.length >= 500) {
        error = "Description cannot exceed 500 characters."
    } else {
        error = defaultErrorMessage;
    }

    taskDescriptionError.textContent = error;
    return error;
}

/* These functions allow dragging of the Add new task form. */
var offsetX, offsetY;
var isDragging = false;

     // Function to start dragging
    function startDrag(e) {
        isDragging = true;
        var popup = document.getElementById("newTask");
        var boundingBox = popup.getBoundingClientRect();
        offsetX = e.clientX - boundingBox.left;
        offsetY = e.clientY - boundingBox.top;
        document.addEventListener("mousemove", drag);
        document.addEventListener("mouseup", endDrag);
    }

    // Function to perform dragging
    function drag(e) {
        if (isDragging) {
            var popup = document.getElementById("newTask");
            popup.style.left = (e.clientX - offsetX) + "px";
            popup.style.top = (e.clientY - offsetY) + "px";
        }
    }

    // Function to end dragging
    function endDrag() {
        isDragging = false;
        document.removeEventListener("mousemove", drag);
        document.removeEventListener("mouseup", endDrag);
    }

    function openPopup() {
        var popup = document.getElementById("newTask");
        popup.style.display = "flex";
        popup.style.flexDirection = "column";
        popup.style.alignItems = "center";
    }
    function closePopup() {
        var popup = document.getElementById("newTask");
        popup.style.display = "none";
    }

/* These functions allow dragging of the expand/details form for a task. */
var offsetX2, offsetY2;
var isDragging2 = false;
    //Same functions for expand button
    function startDragExpand(e) {
        isDragging2 = true;
        var popup = document.getElementById("expandTask");
        var boundingBox = popup.getBoundingClientRect();
        offsetX2 = e.clientX - boundingBox.left;
        offsetY2 = e.clientY - boundingBox.top;
        document.addEventListener("mousemove", dragExpand);
        document.addEventListener("mouseup", endDragExpand);
    }

    function dragExpand (e) {
        if (isDragging2) {
            var popup = document.getElementById("expandTask");
            popup.style.left = (e.clientX - offsetX2) + "px";
            popup.style.top = (e.clientY - offsetY2) + "px";
        }
    }

    function endDragExpand() {
        isDragging2 = false;
        document.removeEventListener("mousemove", dragExpand);
        document.removeEventListener("mouseup", endDragExpand);
    }

    

    function openPopupExpand(task) {   
        // Accessing task details
        var taskName = task['Name'];
        var tag = task['Tag'] || 'N/A'; // Using 'N/A' if tag is not set
        var description = task['Description'];
        console.log(taskName, tag, description);

        // Update HTML elements with task details
        document.getElementById('expandName').value = taskName;
        document.getElementById('expandTag').value = tag;
        document.getElementById('expandDesc').value = description;

        // Show the popup
        var popup = document.getElementById("expandTask");
        popup.style.display = "flex";
        popup.style.flexDirection = "column";
        popup.style.alignItems = "center";
        
        }

    function closePopupExpand() {
        var popup = document.getElementById("expandTask");
        popup.style.display = "none";
    }

    /* This function accepts object of tasks as a parameter, then performs a few functions. 
    * First, it adds an event listener to the expand/detail button - when it is clicked, it assigns the task ID of the task clicked
    * and then sets a few element's values accordingly, as well as insert the GET URL necessary to update/delete tasks.
    * Finally, it calls the function to open the appropriate pop-up. While it breaks some principles to not call the function in the html onclick attribute,
    * This is the only way that I could make it work. -AK
    */
    function sendTaskID(tasks){
            var buttons = document.querySelectorAll('.detailButton');
            buttons.forEach(function(button) {
                button.addEventListener('click', function() {
                    var taskId = this.getAttribute('data-task-id');
                    var task = tasks[taskId];
                    if (task) {
                        document.getElementById('deleteTaskId').value = taskId;
                        document.getElementById('updateTaskId').value = taskId;
                        var actionUrl = "../server/delete_task.php?id=" + taskId;
                        var actionUrl2 = "../server/update_task.php?id=" + taskId;
                        document.getElementById('ExpandTaskDelete').action = actionUrl;
                        document.getElementById('taskExpandForm').action = actionUrl2;
                        // Assuming you want to display task details in a popup or modal
                        openPopupExpand(task);
                    } else {
                        console.error('Task not found');
                    }
                });
            });
    }