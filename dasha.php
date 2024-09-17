<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
body {
  margin: 0;
  font-family: "Lato", sans-serif;
}

:root {
	--c-gray-900: #000000;
	--c-gray-800: #efefef;
	--c-gray-700: #2e2e2e;
	--c-gray-600: #313131;
	--c-gray-500: #969593;
	--c-gray-400: #a6a6a6;
	--c-gray-300: #bdbbb7;
	--c-gray-200: #f1f1f1;
	--c-gray-100: #ffffff;

	--c-green-500: #ffffff;
	--c-olive-500: #ffffff;

	--c-white: var(--c-gray-100);

	--c-text-primary: var(--c-gray-100);
	--c-text-secondary: var(--c-gray-200);
	--c-text-tertiary: var(--c-gray-500);
}


.sidebar {
  margin: 0;
  padding: 0;
  width: 250px;
  background-color: #08c199;
  position: fixed;
  height: 100%;
  overflow: hidden;
  display: flex;
  flex-direction: column;
}

.sidebar h1 {
  text-align: center;
  margin-top: 20px;
}

.sidebar a {
  display: block;
  color: black;
  padding: 16px;
  text-decoration: none;
  transition: color 0.5s ease, background-color 0.5s ease;
}

.sidebar a:hover {
  color: #fff;
  background-color: #333;
}

.sidebar a:hover::after {
  visibility: visible;
  transform: scale(100) translateX(2px);
}

.sidebar h1 .it {
  color: white; /* Set the color of "It!" to white */
}

.sidebar a.active {
  background-color:#e7e7e7;
  color: white;
}

.sidebar a:not(.active) {
  margin-top: 0; /* Reset margin */
}

.sidebar a:first-child {
  margin-top: 40px; /* Adjust space above the first link */
}

.profile {
  display: flex;
  justify-content: space-between;
  padding: 390px 42px;
  align-items: center;
}

.profile img {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  margin-right: 10px;
}

.greeting {
  color: black;
  display: flex;
  flex-direction: column;
  margin-left: 5px; /* Adjust the margin to move the greetings to the left */
}

.greeting > div:nth-child(1) {
  font-weight: bold;
}

.greeting > div:nth-child(2) {
  margin-top: 5px;
}

@media screen and (max-width: 700px) {
.sidebar {
    width: 100%;
    height: auto;
    position: relative;
    justify-content: flex-start;
}
.sidebar a {float: left;}
}

@media screen and (max-width: 400px) {
.sidebar a {
    text-align: center;
    float: none;
}
}

.group {
display: flex;
justify-content: flex-end; /* Move items to the right */
align-items: center; /* Center vertically */
position: relative;
max-width: 190px;
}

.input {
height: 40px;
line-height: 28px;
padding: 0 1rem;
padding-left: 2.5rem;
border: 2px solid transparent;
border-radius: 8px;
outline: none;
background-color: #f3f3f4;
color: #0d0c22;
transition: 0.3s ease;
}

.input::placeholder {
color: #9e9ea7;
}

.input:focus,
.input:hover {
outline: none;
border-color: rgba(247, 127, 0, 0.4);
background-color: #fff;
box-shadow: 0 0 0 4px rgb(247 127 0 / 10%);
}

.icon {
position: absolute;
left: 10rem;
fill: #9e9ea7;
width: 1rem;
height: 1rem;
}

.search-container {
position: fixed;
top: 20px;
right: 11%;
padding: 20px;
display: flex;
justify-content: space-between; /* Align items in the container */
align-items: center; /* Center vertically */
}



.btn {
width: 40px;
height: 40px;
border-radius: 50%; /* Make it circular */
border: 2px solid black; /* Black border */
background-color: white; /* White background */
color: black; /* Black plus sign */
font-size: 24px;
display: flex;
justify-content: center;
align-items: center;
cursor: pointer;
transition: background-color 0.3s, color 0.3s;

}

.btn:hover {
background-color: black; /* Black background on hover */
color: white; /* White plus sign on hover */
}

.addnotes {
display: flex;
align-items: center;
justify-content: flex-end; /* Move the add button to the right */
margin-right: 20px; /* Add margin to separate from the sidebar */
position: fixed;
top: 20px;
right: 1%;
padding: 20px;
}



.add-btn {
width: 40px;
height: 40px;
border-radius: 50%;
border: 2px solid black;
background-color: white;
cursor: pointer;
transition: background-color 0.3s, color 0.3s;
}

.add-btn:hover {
background-color: #b0b0b0;
}

.btn-icon {
fill: none;
}

.add-notes {
margin-left: 10px;
font-size: 16px;
color: black;
}

.all-notes {
    display: flex;
    align-items: center;
    justify-content: flex-end; 
    margin-right: 20px;
    position: fixed;
    top: 25px;
    left: 17%;
    padding: 20px;
    font-size: 28px;
   
}

.all-notes::after {
    content: "";
    position: absolute;
    bottom: 4px; /* Adjust the distance of the line from the text */
    left: 0;
    width: 100%;
    height: 2px; /* Adjust the thickness of the line */
    background-color: transparent; /* Set initial color to transparent */
    transition: background-color 0.3s; /* Add transition effect */
}

.all-notes:hover::after {
    background-color: #10b72f; /* Change to desired hover line color */
    height: 4px;
}



.card {
width: 342px;
height: 303px;
background-color: #ffffff;
border-radius: 8px;
z-index: 1;
position: absolute;
top: calc(8% + 43px);
left: 29%;
transform: translateX(-50%);
border: 1px solid #333; 
}

.tools {
display: flex;
align-items: center;
justify-content: space-between; 
padding: 9px;
}

.note-container {
display: flex;
align-items: center;
margin-right: 10px; 
}

.dots-container {
display: flex;
}

.circle {
padding: 0 4px;
}

.box {
display: inline-block;
align-items: center;
width: 10px;
height: 10px;
padding: 1px;
border-radius: 50%;
}

.red {
background-color: #ff605c;
}

.yellow {
background-color: #ffbd44;
}

.green {
background-color: #00ca4e;
}




.app-body-navigation {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    color: var(--c-text-tertiary);
    background-color: #00cc97;
    padding: 20px; /* Add padding */
    width: 200px; /* Set sidebar width */
}

.app-body-main-content {
    flex-grow: 1; /* Allow the main content to grow to fill available space */
    max-width: 65%;
    margin: auto; /* Center the content horizontally */
    padding: 100px;
    left: 100px; /* Adjusted this value to move the tiles to the right */
    
}

.user-profile {
    display: flex;
    align-items: center;
    border: 0;
    background: transparent;
    cursor: pointer;
    color:#000000;
    transition: 0.25s ease;

    &:hover,
    &:focus {
        color: var(--c-text-primary);
    }

    span:first-child {
        display: flex;
        font-size: 1rem;
        padding-top: 13rem;
        padding-bottom: 13rem;
        /* Remove the border-bottom property */
        /* border-bottom: 1px solid var(--c-gray-600); */
        font-weight: 300;
    }

    span:last-child {
        transition: 0.25s ease;
        display: flex;
        justify-content: center;
        align-items: center;
        width: 42px;
        height: 42px;
        border-radius: 50%;
        overflow: hidden;
        margin-left: 1.5rem;
        flex-shrink: 0;
    }
}


/* 
diri */

.tiles {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(calc(25% - 0.75rem), 1fr)); /* Adjust minmax value as needed */
    column-gap: 1rem;
    row-gap: 1rem;
    margin-top: 1.25rem;
    @media (max-width: 700px) {
        grid-template-columns: repeat(auto-fill, minmax(calc(50% - 0.75rem), 1fr));
    }
    margin-right: -25%;
}


.tile {
    border: 2px solid gray; /* Add gray border */
    border-radius: 8px; /* Add border radius for rounded corners */
  padding: 1rem;
  border-radius: 8px;
  background-color: var(--c-olive-500);
  color: var(--c-gray-900);
  min-height: 200px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  position: relative;
  transition: 0.25s ease;

  &:hover {
    transform: translateY(-5px);
  }

  &:focus-within {
    box-shadow: 0 0 0 2px var(--c-gray-800), 0 0 0 4px var(--c-olive-500);
  }

  &:nth-child(2) {
    background-color: var(--c-green-500);
    &:focus-within {
      box-shadow: 0 0 0 2px var(--c-gray-800), 0 0 0 4px var(--c-green-500);
    }
  }

  &:nth-child(3) {
    background-color: var(-c-gray-800);
    &:focus-within {
      box-shadow: 0 0 0 2px var(--c-gray-800), 0 0 0 4px var(--c-gray-300);
    }
  }

  .tools {
    display: flex;
    align-items: center;
    padding: 9px;
  }

  .circle {
    padding: 0 4px;
  }

  .box {
    display: inline-block;
    align-items: center;
    width: 10px;
    height: 10px;
    padding: 1px;
    border-radius: 50%;
  }

  .red {
    background-color: #ff605c;
  }

  .yellow {
    background-color: #ffbd44;
  }

  .green {
    background-color: #00ca4e;
  }

  a {
    text-decoration: none;
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-weight: 600;

    .icon-button {
      color: inherit;
      border-color: inherit;
      &:hover,
      &:focus {
        background-color: transparent;
        i {
          transform: none;
        }
      }
    }

    &:focus {
      box-shadow: none;
    }

    &:after {
      content: "";
      display: block;
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
    }
  }
}

.tile-header {
  display: flex;
  align-items: center;  
  i {
    font-size: 2.5em;
  }

  h3 {
    display: flex;
    flex-direction: column;
    line-height: 1.375;
    margin-left: 0.5rem;
    span:first-child {
      font-weight: 600;
    }

    span:last-child {
      font-size: 0.825em;
      font-weight: 200;
    }
  }
}






.container-input {
  position: relative;
}

.input {
  width: 260px;
  padding: 7px 2px 11px 6px;
  border-radius: 9999px;
  border: solid 1px #333;
  outline: none;
  opacity: 0.6;
  margin-left: 125%; /* Adjusted margin-left */
}

.container-input svg {
  position: absolute;
  top: 50%;
  left: 10px;
  
}

.input:focus {
  opacity: 1;
  width: 250px;
}



/* Heart button styles */
.heart-button {
    display: flex;
    align-items: center;
    justify-content: space-between;
    text-decoration: none;
    color: var(--c-text-tertiary); /* Initial color */
    transition: color 0.3s ease; /* Smooth color transition on hover */
}

.heart-button:hover .icon-button {
    color: red; /* Change color on hover */
}

/* Additional styles for heart icon */
.heart-icon {
    width: 24px;
    height: 24px;
}

/* Adjust the size of the heart icon as needed */
.icon-button {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    color: var(--c-text-primary);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: 0.25s ease;
    flex-shrink: 0;
}

.icon-button:hover {
    background-color: var(--c-gray-600);
    box-shadow: 0 0 0 4px var(--c-gray-800), 0 0 0 5px var(--c-text-tertiary);
}



/* Positioning the view button */
.view-button {
    position: absolute;
    top: 0;
    right: 0;
    margin: 0.5rem;
    z-index: 1; /* Ensure it's above other content */
}

/* Styling for the eye icon */
.eye-icon {
    width: 24px;
    height: 24px;
    color: var(--c-text-primary); /* Adjust color as needed */
    transition: color 0.3s ease; /* Smooth color transition on hover */
}

/* Adjust the size and color of the eye icon on hover */
.view-button:hover .eye-icon {
    color: blue; /* Change color on hover */
}


</style>
</head>
<body>

<div class="all-notes">
    <span class="all-notes-left">All Notes</span> <!-- "All" text -->

</div>

<div class="search-container">
<div class="group">
    <svg viewBox="0 0 24 24" aria-hidden="true" class="icon">
    <g>
        <path
        d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z"
        ></path>
    </g>
    </svg>
    <input class="input" type="search" placeholder="Search" />
</div>

<div class="addnotes">
    <button class="add-btn" title="Add New Project">
    <svg class="btn-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus">
        <line x1="12" y1="5" x2="12" y2="19" />
        <line x1="5" y1="12" x2="19" y2="12" />
    </svg>
    </button>
    <span class="add-notes">Add Notes</span>
</div>
</div>



<div class="sidebar">

<h1><span class="note">Note</span><span class="it">It!</span></h1>

<a href="#news">All notes</a>
<a href="#contact">Favourites</a>
<a href="#about">Archives</a>
<a href="#logout">Logout</a>
<div class="profile">
<img src="imgs/ac.jpg" alt="Profile Picture">
<div class="greeting">
    <div>Hi Rexy!</div>
    <div>Welcome Back.</div>
</div>
</div>

</div>


            <div class="app-body-main-content">
                <section class="service-section">
                  
                    <div class="tiles">
						
					
						<article class="tile">
							<div class="tile-header">
								<i class="ph-file-light"></i>
								<h3>
									<span>TITLE</span>
									<span>Sample notes.</span>
								</h3>
							</div>
							<!-- View button with eye icon -->
							<a href="#" class="view-button">
								<span class="icon-button">
									<svg xmlns="http://www.w3.org/2000/svg" class="eye-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
										<path d="M3 12c0-2.5 4-7 9-7s9 4.5 9 7-4 7-9 7-9-4.5-9-7zm9-5a3 3 0 100 6 3 3 0 000-6z"></path>
										<circle cx="12" cy="12" r="3"></circle>
									</svg>
								</span>
							</a>
							<!-- Heart button -->
							<a href="#" class="heart-button">
								<span>Date:01/01/2024</span>
								<span class="icon-button">
									<!-- SVG heart icon -->
									<svg xmlns="http://www.w3.org/2000/svg" class="heart-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
										<path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
									</svg>
								</span>
							</a>
						</article>


						<article class="tile">
							<div class="tile-header">
								<i class="ph-file-light"></i>
								<h3>
									<span>TITLE</span>
									<span>Sample notes.</span>
								</h3>
							</div>
							<!-- View button with eye icon -->
							<a href="#" class="view-button">
								<span class="icon-button">
									<svg xmlns="http://www.w3.org/2000/svg" class="eye-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
										<path d="M3 12c0-2.5 4-7 9-7s9 4.5 9 7-4 7-9 7-9-4.5-9-7zm9-5a3 3 0 100 6 3 3 0 000-6z"></path>
										<circle cx="12" cy="12" r="3"></circle>
									</svg>
								</span>
							</a>
							<!-- Heart button -->
							<a href="#" class="heart-button">
								<span>Date:01/01/2024</span>
								<span class="icon-button">
									<!-- SVG heart icon -->
									<svg xmlns="http://www.w3.org/2000/svg" class="heart-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
										<path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
									</svg>
								</span>
							</a>
						</article>
						

						<article class="tile">
							<div class="tile-header">
								<i class="ph-file-light"></i>
								<h3>
									<span>TITLE</span>
									<span>Sample notes.</span>
								</h3>
							</div>
							<!-- View button with eye icon -->
							<a href="#" class="view-button">
								<span class="icon-button">
									<svg xmlns="http://www.w3.org/2000/svg" class="eye-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
										<path d="M3 12c0-2.5 4-7 9-7s9 4.5 9 7-4 7-9 7-9-4.5-9-7zm9-5a3 3 0 100 6 3 3 0 000-6z"></path>
										<circle cx="12" cy="12" r="3"></circle>
									</svg>
								</span>
							</a>
							<!-- Heart button -->
							<a href="#" class="heart-button">
								<span>Date:01/01/2024</span>
								<span class="icon-button">
									<!-- SVG heart icon -->
									<svg xmlns="http://www.w3.org/2000/svg" class="heart-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
										<path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
									</svg>
								</span>
							</a>
						</article>



						<article class="tile">
							<div class="tile-header">
								<i class="ph-file-light"></i>
								<h3>
									<span>TITLE</span>
									<span>Sample notes.</span>
								</h3>
							</div>
							<!-- View button with eye icon -->
							<a href="#" class="view-button">
								<span class="icon-button">
									<svg xmlns="http://www.w3.org/2000/svg" class="eye-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
										<path d="M3 12c0-2.5 4-7 9-7s9 4.5 9 7-4 7-9 7-9-4.5-9-7zm9-5a3 3 0 100 6 3 3 0 000-6z"></path>
										<circle cx="12" cy="12" r="3"></circle>
									</svg>
								</span>
							</a>
							<!-- Heart button -->
							<a href="#" class="heart-button">
								<span>Date:01/01/2024</span>
								<span class="icon-button">
									<!-- SVG heart icon -->
									<svg xmlns="http://www.w3.org/2000/svg" class="heart-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
										<path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
									</svg>
								</span>
							</a>
						</article>



						<article class="tile">
							<div class="tile-header">
								<i class="ph-file-light"></i>
								<h3>
									<span>TITLE</span>
									<span>Sample notes.</span>
								</h3>
							</div>
							<!-- View button with eye icon -->
							<a href="#" class="view-button">
								<span class="icon-button">
									<svg xmlns="http://www.w3.org/2000/svg" class="eye-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
										<path d="M3 12c0-2.5 4-7 9-7s9 4.5 9 7-4 7-9 7-9-4.5-9-7zm9-5a3 3 0 100 6 3 3 0 000-6z"></path>
										<circle cx="12" cy="12" r="3"></circle>
									</svg>
								</span>
							</a>
							<!-- Heart button -->
							<a href="#" class="heart-button">
								<span>Date:01/01/2024</span>
								<span class="icon-button">
									<!-- SVG heart icon -->
									<svg xmlns="http://www.w3.org/2000/svg" class="heart-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
										<path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
									</svg>
								</span>
							</a>
						</article>


						<article class="tile">
							<div class="tile-header">
								<i class="ph-file-light"></i>
								<h3>
									<span>TITLE</span>
									<span>Sample notes.</span>
								</h3>
							</div>
							<!-- View button with eye icon -->
							<a href="#" class="view-button">
								<span class="icon-button">
									<svg xmlns="http://www.w3.org/2000/svg" class="eye-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
										<path d="M3 12c0-2.5 4-7 9-7s9 4.5 9 7-4 7-9 7-9-4.5-9-7zm9-5a3 3 0 100 6 3 3 0 000-6z"></path>
										<circle cx="12" cy="12" r="3"></circle>
									</svg>
								</span>
							</a>
							<!-- Heart button -->
							<a href="#" class="heart-button">
								<span>Date:01/01/2024</span>
								<span class="icon-button">
									<!-- SVG heart icon -->
									<svg xmlns="http://www.w3.org/2000/svg" class="heart-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
										<path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
									</svg>
								</span>
							</a>
						</article>



						<article class="tile">
							<div class="tile-header">
								<i class="ph-file-light"></i>
								<h3>
									<span>TITLE</span>
									<span>Sample notes.</span>
								</h3>
							</div>
							<!-- View button with eye icon -->
							<a href="#" class="view-button">
								<span class="icon-button">
									<svg xmlns="http://www.w3.org/2000/svg" class="eye-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
										<path d="M3 12c0-2.5 4-7 9-7s9 4.5 9 7-4 7-9 7-9-4.5-9-7zm9-5a3 3 0 100 6 3 3 0 000-6z"></path>
										<circle cx="12" cy="12" r="3"></circle>
									</svg>
								</span>
							</a>
							<!-- Heart button -->
							<a href="#" class="heart-button">
								<span>Date:01/01/2024</span>
								<span class="icon-button">
									<!-- SVG heart icon -->
									<svg xmlns="http://www.w3.org/2000/svg" class="heart-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
										<path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
									</svg>
								</span>
							</a>
						</article>


						<article class="tile">
							<div class="tile-header">
								<i class="ph-file-light"></i>
								<h3>
									<span>TITLE</span>
									<span>Sample notes.</span>
								</h3>
							</div>
							<!-- View button with eye icon -->
							<a href="#" class="view-button">
								<span class="icon-button">
									<svg xmlns="http://www.w3.org/2000/svg" class="eye-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
										<path d="M3 12c0-2.5 4-7 9-7s9 4.5 9 7-4 7-9 7-9-4.5-9-7zm9-5a3 3 0 100 6 3 3 0 000-6z"></path>
										<circle cx="12" cy="12" r="3"></circle>
									</svg>
								</span>
							</a>
							<!-- Heart button -->
							<a href="#" class="heart-button">
								<span>Date:01/01/2024</span>
								<span class="icon-button">
									<!-- SVG heart icon -->
									<svg xmlns="http://www.w3.org/2000/svg" class="heart-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
										<path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
									</svg>
								</span>
							</a>
						</article>



						
                    </div>
			</div>



</body>
</html>
