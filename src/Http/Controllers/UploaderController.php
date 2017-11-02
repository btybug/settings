<?php

namespace Btybug\Settings\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\Term;
use Datatables;
use Illuminate\Http\Request;
use Sahakavatar\Create\Models\CHelper;
use Sahakavatar\Media\Media;
use Btybug\Settings\Uploaders;

/**
 * @property CHelper chelper
 * @property Term term
 */
class UploaderController extends Controller
{
    protected $dhelp;
    private $settings = null;
    private $helpers = null;

    /**
     * UploaderController constructor.
     */
    public function __construct()
    {
        $this->helpers = new helpers;
        $this->dhelp = new dbhelper;
        $this->term = new Term;
        $this->chelper = new CHelper;
        $this->home = '/admin/settings/uploaders';
        $this->settings = [
            'browseLabel' => 'Browse',
            'removeLabel' => 'Remove',
            'uploadLabel' => 'Upload'
        ];
    }

    public function getIndex()
    {

        $form_fields = [
            '#' => '#',
            'title' => 'Title',
            "short_code" => "Short Code",
            'allowed_ext' => "Allowed Extensions",
            'action' => 'Action'
        ];
        $columns = $this->dhelp->getColumnsJson($form_fields);

        return view('settings::uploaders.index', compact(['form_fields', 'columns']));
    }

    /**
     * Add new uploader with settings
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCreate()
    {

        $folders = $this->chelper->termsFormatArr($this->term->mediaFolders());
        $settings = $this->settings;
        return view('settings::uploaders.create', compact(['folders', 'settings']));
    }


    /**
     * Save uploader in DB
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postCreate(Request $request)
    {
        $req = $request->all();
        $req['settings'] = serialize($req['settings']);
        $req['thumb'] = serialize($req['thumb']);

        $req['allow_multiple'] = (!isset($req['allow_multiple'])) ? 0 : $req['allow_multiple'];
        $uploader = Uploaders::create($req);
        $id = $uploader->id;

        $uploader->short_code = 'UPLOADER-' . $id;
        $uploader->save();

        $this->helpers->updatesession('Uploader added successfully');

        return redirect($this->home);
    }

    /**
     * Update uploader Settings
     *
     * @param null $id of uploader
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function getUpdate($id = null)
    {
        if ($id) {
            $uploader = Uploaders::find($id);
            $settings = unserialize($uploader->settings);
            $thumb = unserialize($uploader->thumb);
            $folders = $this->chelper->termsFormatArr($this->term->mediaFolders());

            return view('settings::uploaders.update', compact(['uploader', 'settings', 'thumb', 'folders']));
        } else {
            return redirect($this->home);
        }

    }


    /**
     * Update uploader settings
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postUpdate(Request $request)
    {
        $id = $request->id;
        $model = Uploaders::find($id);
        $req = $request->all();

        $req['settings'] = serialize($req['settings']);
        $req['thumb'] = serialize($req['thumb']);

        $req['allow_multiple'] = (!isset($req['allow_multiple'])) ? 0 : $req['allow_multiple'];
        $model->update($req);
        $this->helpers->updatesession();

        return redirect($this->home);
    }

    /**
     * Delete uploader
     *
     * @param Request $request
     * @internal param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postDelete(Request $request)
    {
        $id = $request->id;
        Uploaders::destroy($id);
        $this->helpers->updatesession('Uploader Deleted Successfully');

        return redirect($this->home);
    }

    public function postDeleteblk(Request $request)
    {
        $ids = $request->ids;
        $ids_arr = explode(",", $ids);
        if (is_array($ids_arr)) {
            foreach ($ids_arr as $id) {
                Uploaders::destroy($id);
            }
        }
        $this->helpers->updatesession('Uploader Deleted Successfully');

        return redirect($this->home);
    }


    public function getData()
    {
        $data = Uploaders::orderBy('id', 'DESC')->get();
        $obj = Datatables::of($data);

        $obj->addColumn(
            '#',
            function ($class) {
                return '<input name="plugin" class="del_select chk_unchk_all" type="checkbox" value="' . $class->id . '" />';
            }
        );
        $obj->addColumn(
            'allowed_ext',
            function ($class) {
                $ext = ($class->img_ext) ? $class->img_ext . "," : " ";
                $ext .= ($class->vid_ext) ? $class->vid_ext . "," : " ";
                $ext .= ($class->music_ext) ? $class->music_ext . "," : " ";
                $ext .= ($class->doc_ext) ? $class->doc_ext . "," : " ";

                return $ext;
            }
        );


        $obj->addColumn(
            'action',
            $this->dhelp->actionBtns(
                [
                    'edit' => ['link' => '/admin/settings/uploaders/update/{!! $id !!}'],
                    'delete_post' => ['link' => '/admin/settings/uploaders/delete', 'id' => '{!! $id !!}'],
                ]
            )
        );

        $obj = $obj->make(true);

        return $obj;

    }


}
