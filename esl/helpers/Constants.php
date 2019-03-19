<?php
/**
 * Created by PhpStorm.
 * User: marvin
 * Date: 1/31/18
 * Time: 1:28 PM
 */

namespace Esl\helpers;


class Constants
{
    const STATUS_OK = 200;
    const STATUS_ERROR = 401;
    const LEAD_CUSTOMER = 'lead';
    const EXISTING_CUSTOMER = 'customer';
    const TARIFF_KPA = 'kpa';
    const TARIFF_INTERNAL = 'internal';
    const TARIFF_UNIT_TYPE_LUMPSUM = 'Lumpsum';
    const TARIFF_UNIT_TYPE_GRT = 'grt';
    const TARIFF_UNIT_TYPE_LOA = 'loa';
    const TARIFF_UNIT_TYPE_PERDAY = 'per day';
    const LEAD_QUOTATION_PENDING = 'pending';
    const LEAD_QUOTATION_REQUEST = 'requested';
    const LEAD_QUOTATION_APPROVED = 'approved';
    const LEAD_QUOTATION_REVISION = 'revision';
    const LEAD_QUOTATION_DECLINED = 'disapproved';
    const LEAD_QUOTATION_DECLINED_CUSTOMER = 'declined';
    const LEAD_QUOTATION_CONVERTED = 'converted';
    const LEAD_QUOTATION_WAITING = 'waiting';
    const LEAD_QUOTATION_ACCEPTED = 'accepted';
    const CUSTOMER = 'customer';
    const Q_APPROVAL_TITLE = 'Quotation Approval Request';
    const Q_APPROVED_TITLE = 'Quotation Approved';
    const Q_ACCEPTED_TITLE = 'Quotation Accepted';
    const Q_SEND_TO_CUSTOMER_TITLE = 'Quotation sent to customer';
    const Q_SEND_TO_CUSTOMER_TEXT = 'Quotation sent to customer  waiting for customer response';
    const Q_CUSTOMER_ACCEPTED_TEXT = 'The customer accepted the Quotation';
    const Q_DISAPPROVED_TITLE = 'Quotation disapproved';
    const Q_DECLINED_C_TITLE = 'Quotation declined';
    const Q_DECLINED_C_TEXT = 'Quotation declined by customer';
    const Q_APPROVED_TEXT = 'Your Quotation has been approved';
    const Q_DISAPPROVED_TEXT = 'Your Quotation has been disapproved';
    const Q_APPROVAL_TEXT = 'You have a new Quotation to approve';
    const DEPARTMENT_AGENCY = 'Transport';
//    transport

    const TRANSPORT_IMPORT = 'Import';
    const TRANSPORT_EXPORT = 'Export';
    const TRANSPORT_ALL = 'all';
    const TRANSPORT_CLEARING = 'Clearing';
    const TRANSPORT_QUOTATION_PENDING = 'Pending';
    const TRANSPORT_TYPE_IMPORT = 'Import';
    const TRANSPORT_TYPE_EXPORT = 'Export';

    const PO_REQUEST = 'requested';
    const PO_APPROVED = 'approved';
    const PO_DISAPPROVED = 'disapproved';

    const EMAILS_CC = [
        'it.support@esl-eastafrica.com',
        'accounts@esl-eastafrica.com',
        'maurine.atieno@esl-eastafrica.com',
        'marvincollins14@gmail.com',
        'imports@freightwell.com',
        'info@freightwell.com',
        'audit@esl-eastafrica.com'];

    const PERMISSIONS = [
        'manage-user' => 'Manage Users',
        'manager' => 'Manager',
        'admin' => 'System Admin',
        'generate-quotation' => 'Generate Quotation',
        'view-quotation' => 'View Quotation',
        'approve-quotation' => 'Approve Quotation',
        'manage-cargo-types' => 'Manage Cargo Types',
        'manage-stages' => 'Manage Stages',
        'manage-contracts' => 'Manage Contracts',
        'manage-services' => 'Manage Services',
        'manage-docs' => 'Manage Docs',
        'manage-dsr' => 'Manage DSR',
        'manage-customers' => 'Manage Customers',
        'manage-roles' => 'Manage Roles',
        'can-delete' => 'Can Delete',
    ];

    const TRANSPORT_CC = [
        'audit@esl-eastafrica.com',
        'maurine.atieno@esl-eastafrica.com',
        'florence.tuei@esl-eastafrica.com',
        'evans.ngala@esl-eastafrica.com',
        'accounts@freightwell.com',
        'accounts@sovereignlog.com'
    ];
}