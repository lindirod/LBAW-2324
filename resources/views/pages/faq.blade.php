@extends('layouts.app')

@section('content')
  <div class="contacts-container">
   <section>
        <h2>Frequent Asked Questions</h2>
        <h3>Find out more about us by browsing the FAQ's on how our Project Management System works, quickly.
          Get concise information about user roles, and task organization for enhanced experiences. If you need more help, please call support. 
          Find out more and improve on your Project management experience with our Frequently Asked Questions (FAQ's).
        </h3> 
  </section>
  </div>
  <section class="faq-container">
        <div class="filterDiv general">
            <h1 class="section-title"> General Information</h1>
            <!-- faq question -->
            <h2 id="general-coord" class="faq-page">Are there any features related to project invitations? </h2>

            <!-- faq answer -->
            <div class="faq-body" id="general-coord-answer">
                <p>
                    Yes, users can manage project invitations, including accepting or declining invitations. 
                    Coordinators have the ability to invite users to projects via email. 
                </p>
            </div>

              <!-- faq question -->
            <h2 id="general-leave" class="faq-page"> Can I leave a project if needed?</h2>

            <!-- faq answer -->
            <div class="faq-body" id="general-leave-answer" >
                <p> 
                    Certainly, users have the option to leave a project.
                    This is useful if your involvement in a particular project is no longer required.
                </p>
            </div>
        </div>

        <div class="filterDiv tasks">
            <h1 class="section-title"> Tasks</h1>

            <!-- faq question -->
            <h2 id="tasks-org" class="faq-page">How are tasks organized within the system?</h2>

            <!-- faq answer -->

            <div class="faq-body" id="tasks-org-answer">
                <p> 
                    Tasks can be organized into groups, and users can prioritize tasks, assign labels, set due dates, and comment on tasks. 
                    It is also essential to track the user who defined the task and the user who completed it.
                </p>
            </div>

            <h2 id="tasks-notif" class="faq-page"> What happens if I complete a task or if a task is assigned to me? </h2>

            <!-- faq answer -->

            <div class="faq-body" id="tasks-notif-answer">
                <p> 
                    You will receive notifications for completed tasks and assignments.
                    These notifications keep you informed about changes in task status and project dynamics.
                </p>
            </div>
        </div>
       
        <div class="filterDiv roles">
          <h1 class="section-title"> Available roles</h1>
            <!-- faq question -->
            <h2 id="roles-admin" class="faq-page"> What is the expected role of administrators in the system?</h2>

            <!-- faq answer -->
            <div class="faq-body" id="roles-admin-answer">
                <p>
                    Administrators can browse projects and view project details but  are independent of user accounts,
                    ensuring a clear distinction between administrative and user roles.
                </p>
            </div>
            <!-- faq question -->
            <h2 id="roles-coord" class="faq-page">What features are available to project coordinators?</h2>

            <!-- faq answer -->
            <div class="faq-body" id="roles-coord-answer">
                <p> 
                    Project coordinators have additional responsibilities, including adding users to projects, assigning new coordinators, editing project details, 
                    assigning tasks to members, removing project members, and archiving projects.
                </p>
            </div>
        </div>

  </section>
@endsection
