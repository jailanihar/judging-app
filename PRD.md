# PRD: Institutional Innovation Award Platform

## 1. Executive Summary
The Institutional Innovation Award Platform is a secure, high-fidelity web application designed to facilitate a structured, two-stage judging process for institutional awards. The platform enables administrators to manage projects, define evaluation criteria, and monitor the progress of both internal and external judging panels in real-time.

## 2. Target Audience
*   **Program Administrators:** Responsible for project intake, criteria definition, judging oversight, and process control.
*   **Internal Judges:** Institutional staff who conduct the primary round of technical and feasibility assessments.
*   **External Judges:** Industry experts who perform the final evaluation round on shortlisted or selected projects.

## 3. Core Functional Requirements

### 3.1 Administrative Control
*   **Project Roster Management:** Create, edit, and archive project submissions.
*   **Judging Workflow Control:** Granular "Open/Closed" toggles for judging status. *Business Rule: Only one project should be evaluated at a time to ensure panel focus.*
*   **Criteria Configuration:** Define alphanumeric criteria (e.g., 1.1, 1.2) with weights and descriptions.
*   **Confirmation Safety:** All critical status changes (judging toggles, criteria activation) must require explicit modal confirmation.

### 3.2 Judging & Grading
*   **Two-Stage Process:** Projects must pass through Internal Judging before proceeding to External Judging.
*   **Scoring System:** Quantitative grading on a scale of 0–5 for every active criterion.
*   **Progress Tracking:** Visual indicators showing completion status (e.g., "3/5 Graded").

### 3.3 Oversight & Analytics
*   **Admin Dashboard:** High-level metrics showing total projects, judge counts, and completion percentages.
*   **Judging Alerts:** Proactive identification of judges with incomplete assignments.
*   **Judges Oversight:** Detailed view of individual judge progress across their assigned projects.
*   **Score Aggregation:** Real-time calculation of average scores per project for both internal and external cohorts.

## 4. User Experience & Design
*   **Visual Identity:** "Institutional Innovation" – a professional, trustworthy aesthetic using a navy and teal color palette.
*   **Navigation:** Persistent sidebar for administrative functions and top navigation for global dashboard and reporting.
*   **Responsiveness:** Primary interface optimized for Desktop use (1440px+).

## 5. Information Architecture
*   **Dashboard:** Real-time metrics and alerts.
*   **Project Queue:** Status monitoring and judging control.
*   **Judges Overview:** Detailed tracking of panel completion.
*   **Project Administration:** Roster and criteria configuration.
*   **Grading Interface:** Focused evaluation workspace for judges.

## 6. Future Roadmap
*   **Weighting System:** Advanced calculation logic for criteria weights.
*   **Audit Log:** History of administrative changes.
*   **Final Report Generation:** Exportable PDF summaries for award winners.
*   **Judge Leaderboard:** Gamification and activity tracking for panels.