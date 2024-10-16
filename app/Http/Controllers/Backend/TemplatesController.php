<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\EmailTemplate;
use App\Models\EmailTemplateModule;
use Auth;
use Illuminate\Http\Request;

class TemplatesController extends Controller
{
    public function index()
    {
        $pageTitle = trans('notifications.map_notification.title');
        $pageDescription = trans('notifications.map_notification.description');
        $breadCrum[] = ['title' => trans('breadcrumbs.notifications_center'), 'url' => route('map-templates')];
        $breadCrum[] = ['title' => trans('breadcrumbs.client_notifications'), 'url' => ''];
        $useBreadCrum = 'yes';
        $clientTemplatesData = EmailTemplate::get();
        $systemClientTemplatesData = EmailTemplateModule::get();

        return view('backend.templates.index')->with(compact('pageTitle', 'pageDescription', 'breadCrum', 'useBreadCrum', 'clientTemplatesData', 'systemClientTemplatesData'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function notificationTemplates()
    {
        $pageTitle = trans('notifications.view_notification.title');
        $pageDescription = trans('notifications.view_notification.description');
        $breadCrum[] = ['title' => trans('breadcrumbs.notifications_center'), 'url' => route('map-templates')];
        $breadCrum[] = ['title' => trans('breadcrumbs.notification_templates'), 'url' => ''];
        $useBreadCrum = 'yes';

        return view('backend.templates.view')->with(compact('pageTitle', 'pageDescription', 'breadCrum', 'useBreadCrum'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addTemplates()
    {
        $pageTitle = trans('notifications.add_notification.title');
        $pageDescription = trans('notifications.add_notification.description');
        $breadCrum[] = ['title' => trans('breadcrumbs.notifications_center'), 'url' => route('map-templates')];
        $breadCrum[] = ['title' => trans('breadcrumbs.add_client_template'), 'url' => ''];
        $useBreadCrum = 'yes';
        $template_modules = EmailTemplateModule::get();

        return view('backend.templates.add')->with(compact('pageTitle', 'pageDescription', 'breadCrum', 'useBreadCrum', 'template_modules'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function editTemplates($id)
    {
        $pageTitle = trans('notifications.edit_notification.title').'of <b>'.' Reset Password '.'</b>';
        $pageDescription = trans('notifications.edit_notification.description');
        $breadCrum[] = ['title' => trans('breadcrumbs.notifications_center'), 'url' => route('map-templates')];
        $breadCrum[] = ['title' => trans('breadcrumbs.edit_client_template'), 'url' => ''];
        $useBreadCrum = 'yes';

        $template_modules = EmailTemplateModule::get();
        $template_row = EmailTemplate::where('id', $id)->first();
        $template_row = json_decode(json_encode($template_row), true);

        return view('backend.templates.add')->with(compact('pageTitle', 'pageDescription', 'breadCrum', 'useBreadCrum', 'id', 'template_row', 'template_modules'));
    }

    public function getEmailTemplates(Request $request)
    {
        ///die("aaaa");

        $aColumns = ['template_name'];

        $result = EmailTemplate::select($aColumns)->AddSelect('id', 'user_id')->where(['type' => 0]);

        $iStart = $request->get('iDisplayStart');
        $iPageSize = $request->get('iDisplayLength');

        if ($request->get('iSortCol_0') != null) { //iSortingCols
            $sOrder = 'ORDER BY  ';

            for ($i = 0; $i < intval($request->get('iSortingCols')); $i++) {
                if ($request->get('bSortable_'.intval($request->get('iSortCol_'.$i))) == 'true') {
                    $sOrder .= $aColumns[intval($request->get('iSortCol_'.$i))].'
				 	'.$request->get('sSortDir_'.$i).', ';
                }
            }

            $sOrder = substr_replace($sOrder, '', -2);
            if ($sOrder == 'ORDER BY') {
                $sOrder = ' id ASC';
            }
        }
        $OrderArray = explode(' ', $sOrder);

        $sKeywords = $request->get('sSearch');
        if ($sKeywords != '') {

            $result->Where(function ($query) use ($sKeywords) {
                $query->where('template_name', 'LIKE', "%{$sKeywords}%");
            });
        }

        for ($i = 0; $i < count($aColumns); $i++) {
            $request->get('sSearch_'.$i);
            if ($request->get('bSearchable_'.$i) == 'true' && $request->get('sSearch_'.$i) != '') {
                $result->orWhere($aColumns[$i], 'LIKE', '%'.$request->orWhere('sSearch_'.$i).'%');
            }
        }

        $iTotal = $result->count();
        $iFilteredTotal = $iTotal;

        if ($iStart != null && $iPageSize != '-1') {
            $result->skip($iStart)->take($iPageSize);
        }

        $poolData = $result->get();

        $output = [
            'sEcho' => intval($request->get('sEcho')),
            'iTotalRecords' => $iTotal,
            'iTotalDisplayRecords' => $iFilteredTotal,
            'aaData' => [],
        ];
        $i = 0;
        foreach ($poolData as $aRow) {
            $id = $aRow->id;

            $sOptions = '';
            if (1) {

                $route = url('/admin/templates/edit/'.$aRow->id);
                $sOptions .= '<a href="'.$route.'" class="action">Edit </a>';

                $sOptions .= '<a href="javascript:;" onclick="deleteClientTemplate('.$id.')" class="delete" data-target="#delete2" data-toggle="modal">
                                                   delete
                                                </a>';

            }

            $output['aaData'][] = [
                'DT_RowId' => "row_{$aRow->id}",
                $aRow->template_name,
                $sOptions];
            $i++;
        }

        echo json_encode($output);
    }

    public function saveClientTemplate(Request $request)
    {
        $data = [
            'module_id' => $request->modules,
            'template_name' => $request->template_name,
            'subject_title' => $request->subject,
            'email_template' => $request->content_html,
            'notification_text' => $request->notification_text,
        ];
        $data['user_id'] = Auth::user()->id;

        if ($request->id != 'add') {
            // update record
            EmailTemplate::where('id', $request->id)->update($data);
            $message = 'Updated Successfully';
        } else {
            EmailTemplate::insert($data);
            $message = 'Added Successfully';
        }
        $status = 'success';

        return redirect('/admin/templates')->with('message-success', 'Saved Successfully');
    }

    public function deleteClientTemplate(Request $request)
    {
        ///die("1111");
        $templateData = EmailTemplate::where('id', $request->id)->select('template_name')->first();

        $templateData = json_decode(json_encode($templateData), true);

        if ($templateData) {
            EmailTemplate::where('id', $request->id)->delete();
            $message = trans('common.message.delete');
            $message = str_replace('%%template_name%%', $templateData['template_name'], $message);
            $status = 'success';
        } else {
            $status = 'fail';
            $message = trans('app.error.heading');
        }
        echo json_encode(['status' => $status, 'message' => $message]);
    }

    public function saveMapedTemplate(Request $request)
    {
        $data = [
            'template_id' => $request->template_id,
            'email_status' => $request->email_template,
            'notification_status' => $request->email_text,
        ];

        EmailTemplateModule::where('id', $request->id)->update($data);
        echo json_encode(['status' => 'success', 'message' => trans('Saved')]);
    }
}
