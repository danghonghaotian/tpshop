<?php
/**
 * ============================================================================
 * * 版权所有 2005-2016 跃飞科技网络服务有限公司，并保留所有权利。
 * 网站地址: http://www.gtzhong.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: 钟贵廷 $
 * $Email:gtzhong@gtzhong.com
 * $Id: Page.class.php  2016-12-11 10:35:03 钟贵廷 $
*/

namespace Admin\Component;

class Page {

    private $total; //数据表中总记录数
    private $listRows; //每页显示行数
    private $limit;
    private $uri;
    private $pageNum; //页数
    public $config = array('header' => "个记录", "prev" => "上一页", "next" => "下一页", "first" => "首 页", "last" => "尾 页");
    private $listNum = 8;

    /*
     * $total 
     * $listRows
     */

    public function __construct($total, $listRows = 10, $pa = "") {
        $this->total = $total;
        $this->listRows = $listRows;
        $this->uri = $this->getUri($pa);
        $this->pageNum = ceil($this->total / $this->listRows);
        //初始化(修复直接在url修改页面)
        $page = trim($_GET["page"]);
        if(!is_numeric($page))
        {
            $page = 1;
        }
        else
        {
            if($page<=0)
            {
                $page = 1;
            }
        }
        if($page > $this->pageNum)
        {
            $page = $this->pageNum;
        }
        if(empty($page))
        {
            $page = 1;
        }
        $this->page = $page;
        $this->limit = $this->setLimit();
    }

    private function setLimit() {
        return ($this->page - 1) * $this->listRows . ", {$this->listRows}";
    }

    private function getUri($pa) {
        $url = $_SERVER["REQUEST_URI"] . (strpos($_SERVER["REQUEST_URI"], '?') ? '' : "?") . $pa;
        $parse = parse_url($url);



        if (isset($parse["query"])) {
            parse_str($parse['query'], $params);
            unset($params["page"]);
            $url = $parse['path'] . '?' . http_build_query($params);
        }

        return $url;
    }

    function __get($args) {
        if ($args == "limit")
            return $this->limit;
        else
            return null;
    }

    private function start() {
        if ($this->total == 0)
            return 0;
        else
            return ($this->page - 1) * $this->listRows + 1;
    }

    private function end() {
        return min($this->page * $this->listRows, $this->total);
    }

    private function first() {
        $html = "";
        if ($this->page == 1)
            $html.='';
        else
            $html.="&nbsp;&nbsp;<a href='{$this->uri}&page=1'>{$this->config["first"]}</a>&nbsp;&nbsp;";

        return $html;
    }

    private function prev() {
        $html = "";
        if ($this->page == 1)
            $html.='';
        else
            $html.="&nbsp;&nbsp;<a href='{$this->uri}&page=" . ($this->page - 1) . "'>{$this->config["prev"]}</a>&nbsp;&nbsp;";

        return $html;
    }

    private function pageList() {
        $linkPage = "";

        $inum = floor($this->listNum / 2);

        for ($i = $inum; $i >= 1; $i--) {
            $page = $this->page - $i;

            if ($page < 1)
                continue;

            $linkPage.="&nbsp;<a href='{$this->uri}&page={$page}'>{$page}</a>&nbsp;";
        }

        $linkPage.="&nbsp;{$this->page}&nbsp;";


        for ($i = 1; $i <= $inum; $i++) {
            $page = $this->page + $i;
            if ($page <= $this->pageNum)
                $linkPage.="&nbsp;<a href='{$this->uri}&page={$page}'>{$page}</a>&nbsp;";
            else
                break;
        }

        return $linkPage;
    }

    private function next() {
        $html = "";
        if ($this->page == $this->pageNum)
            $html.='';
        else
            $html.="&nbsp;&nbsp;<a href='{$this->uri}&page=" . ($this->page + 1) . "'>{$this->config["next"]}</a>&nbsp;&nbsp;";

        return $html;
    }

    private function last() {
        $html = "";
        if ($this->page == $this->pageNum)
            $html.='';
        else
            $html.="&nbsp;&nbsp;<a href='{$this->uri}&page=" . ($this->pageNum) . "'>{$this->config["last"]}</a>&nbsp;&nbsp;";

        return $html;
    }

    private function goPage() {
        return '&nbsp;&nbsp;<input type="text" onkeydown="javascript:if(event.keyCode==13){var page=(this.value>' . $this->pageNum . ')?' . $this->pageNum . ':this.value;location=\'' . $this->uri . '&page=\'+page+\'\'}" value="' . $this->page . '" style="width:25px"><input class="button" type="button" value="GO" onclick="javascript:var page=(this.previousSibling.value>' . $this->pageNum . ')?' . $this->pageNum . ':this.previousSibling.value;location=\'' . $this->uri . '&page=\'+page+\'\'">&nbsp;&nbsp;';
    }

    function fpage($display = array(0, 1, 2, 3, 4, 5, 6, 7, 8)) {
        $html[0] = "&nbsp;&nbsp;共有<b>{$this->total}</b>{$this->config["header"]}&nbsp;&nbsp;";
        $html[1] = "&nbsp;&nbsp;每页显示<b>" . ($this->end() - $this->start() + 1) . "</b>条，本页<b>{$this->start()}-{$this->end()}</b>条&nbsp;&nbsp;";
        $html[2] = "&nbsp;&nbsp;<b>{$this->page}/{$this->pageNum}</b>页&nbsp;&nbsp;";

        $html[3] = $this->first();
        $html[4] = $this->prev();
        $html[5] = $this->pageList();
        $html[6] = $this->next();
        $html[7] = $this->last();
        $html[8] = $this->goPage();
        $fpage = '';
        foreach ($display as $index) {
            $fpage.=$html[$index];
        }

        return $fpage;
    }

}
