<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com
 * https://www.sigasmart.com.br
 */

namespace App\Suports\Common;


final class Options
{
    const DEFAULT_COLUMN_ODER_DIRECTION = 'id';
    const DEFAULT_COLUMN_STATUS = 'status';
    const DEFAULT_INITIAL_STATUS = 'all';
    const DEFAULT_PUBLISHED_STATUS = 'published';
    const DEFAULT_DRAFT_STATUS = 'draft';
    const DEFAULT_DELETED_STATUS = 'deleted';
    const DEFAULT_COLUMN_DATE = 'date';
    const DEFAULT_COLUMN_UPDATE = 'updated';
    const DEFAULT_TITLE = 'Basic Table';
    const DEFAULT_ORDER_DESC = 'DESC';
    const DEFAULT_ORDER_ASC = 'ASC';
    const DEFAULT_INITIAL_SHOW_SEARCH = true;
    const DEFAULT_INITIAL_DOWNLOAD_CSV = true;
    const DEFAULT_INITIAL_DOWNLOAD_PDF = false;
    const DEFAULT_INITIAL_DOWNLOAD_PRINT = false;
    const DEFAULT_INITIAL_DOWNLOAD_ZIP = true;

    /**
     * NAME DAS VARIABLES
     */

    const NAME_SHOW_TITLE = 'showTitle';
    const NAME_SHOW_COLUMN_ORDER = 'showColumnOrder';
    const NAME_SHOW_STATUS_COLUMN = 'showStatusColumn';
    const NAME_SHOW_DATE_COLUMN = 'showDateColumn';
    const NAME_SHOW_ORDER_DIRECTION = 'showOrderDirection';
    const NAME_SHOW_ENDPOINT = 'showEndpoint';
    const NAME_SHOW_ENDPOINT_BACK = 'showEndpointBack';
    const NAME_SHOW_STATUS_ITEMS = 'showStatusItems';
    const NAME_SHOW_ITEMS = 'showItems';
    const NAME_SHOW_SEARCH = 'showSearch';
    const NAME_SHOW_STATUS = 'showStatus';
    const NAME_SHOW_ITEM_PER_PAGE = 'showItemPerPage';
    const NAME_SHOW_SORT_OPTIONS = 'showSortOptions';
    const NAME_SHOW_DOWNLOAD_CSV = 'showDownloadCSV';
    const NAME_SHOW_DOWNLOAD_PDF = 'showDownloadPDF';
    const NAME_SHOW_PRINT = 'showDownloadPRINT';
    const NAME_SHOW_ZIP = 'showDownloadZIP';


    /**
     * NAME VARIBLES HELPER
     */

    const DEFAULT_COLUMN_AVATAR = "avatar";
    const DEFAULT_COLUMN_COVER = "cover";
    const DEFAULT_COLUMN_FILE = "file";
    const DEFAULT_COLUMN_SLUG = "slug";
    const DEFAULT_COLUMN_SLUG_ORIGEM = "name";

    const DEFAULT_MESSAGE_TITLE = "Operação";
    const MESSAGE_TYPE_SUCCESS = "success";
    const MESSAGE_TYPE_ERROR = "danger";
    const MESSAGE_TYPE_INFO = "info";
    const MESSAGE_TYPE_ALERT = "warning";
}
