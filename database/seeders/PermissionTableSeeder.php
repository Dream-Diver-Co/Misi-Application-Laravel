<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            // Admin
            'show-admin-list',
            'create-new-admin',
            'update-admin',
            'delete-admin',
            'restore-admin',
            // Screener
            'show-screener-list',
            'update-screener',
            'delete-screener',
            // Heralmelding
            'show-heralmelding-list',
            'update-heralmelding',
            'delete-heralmelding',
            // PIB
            'show-pib-list',
            'update-pib',
            'delete-pib',
            // PIT
            'show-pit-list',
            'update-pit',
            'delete-pit',
            // VTCB
            'show-vtcb-list',
            'update-vtcb',
            'delete-vtcb',
            // YES Approval
            'show-yes-approval-list',
            'update-yes-approval',
            'delete-yes-approval',
            // NO Approval
            'show-no-approval-list',
            'update-no-approval',
            'delete-no-approval',
            // Appointment Group
            'create-appointment',
            'show-appointment-group-list',
            'update-appointment-group',
            'delete-appointment-group',
            // Group
            'show-group-list',
            'create-new-group',
            'update-group',
            'delete-group',
            'view-group-permission',
            'update-group-permission',
            'add-group-permission',
            // Therapist
            'show-therapist-list',
            'add-new-therapist',
            'update-therapist',
            'delete-therapist',
            // Therapist Schedule
            'show-therapist-schedule-list',
            'add-new-therapist-schedule',
            'update-therapist-schedule',
            'delete-therapist-schedule',
            // Email Template
            'show-email-template-list',
            'add-new-email-template',
            'update-email-template',
            'delete-email-template',
            // Question
            'show-question-list',
            'add-new-question',
            'update-question',
            'delete-question',
            // Missing Info
            'show-missing-info-list',
            'update-missing-info',
            'delete-missing-info',
            // Patient
            'show-patient-list',
            'add-new-patient',
            'update-patient-info',
            'delete-patient-info',
            // ZD Patient
            //'show-all-ticket-list',
            'add-new-zd-patient',
            'update-zd-patient',
            'delete-zd-patient',
            //All Ticket
            'show-all-ticket-list',
            'add-new-ticket',
            'update-ticket',
            'delete-ticket',
            // Schedule
            'show-schedule-list',
            'add-new-schedule',
            'update-schedule',
            'delete-schedule',
            // Cancel Ticket
            'create-intake-appointment-list',
            'show-cancel-ticket-list',
            'update-cancel-ticket',
            'delete-cancel-ticket',
            // Cancel Appointment
            'create-cancel-appointment',
            'show-cancel-appointment',
            'update-cancel-appointment',
            'delete-cancel-appointment',
            // Intake Appointment
            'show-intake-appointment',
            'update-intake-appointment',
            'delete-intake-appointment',
            // Ticket
            'show-ticket-list',
            //'add-new-ticket',
            'ticket-show',
            'update-ticket-info',
            'delete-ticket-info',
            'ticket-replies-info',
            'ticket-replies-info-added',
            'ticke-show-replies-info',
            'ticket-reply-updated-info',
            'ticket-reply-deleted-info',
            'tickethistory-activities-list',
            'tickethistory-activities-show-list',
            'ticket-assigned-successfully',
            'ticket-cancelled-successfully',
            'ticket-file-delete-successfully',
            // Ticket Department
            'show-ticket-department-list',
            'add-new-ticket-department',
            'ticket-department-info-show',
            'ticket-department-updated-info',
            'ticket-department-info-delete',
            // Appointment
            'show-appointment-list',
            'add-new-appointment-create',
            'appointment-info-show',
            'appointment-update',
            'assigned-appointment-ticket-status',
            'appointment-delete',
            'delete-file-appointment',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
