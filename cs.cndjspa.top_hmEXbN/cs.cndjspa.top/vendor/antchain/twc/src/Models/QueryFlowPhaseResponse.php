<?php

// This file is auto-generated, don't edit it. Thanks.

namespace AntChain\TWC\Models;

use AlibabaCloud\Tea\Model;

class QueryFlowPhaseResponse extends Model
{
    // 请求唯一ID，用于链路跟踪和问题排查
    /**
     * @var string
     */
    public $reqMsgId;

    // 结果码，一般OK表示调用成功
    /**
     * @var string
     */
    public $resultCode;

    // 异常信息的文本描述
    /**
     * @var string
     */
    public $resultMsg;

    // 交易Hash
    /**
     * @var string
     */
    public $txHash;

    // 存证状态，FINISH(生成完毕)、INIT(初始化中)、FAILED(生成失败)
    /**
     * @var string
     */
    public $status;

    // 阶段注册成功时间戳
    /**
     * @var int
     */
    public $registerTime;
    protected $_name = [
        'reqMsgId'     => 'req_msg_id',
        'resultCode'   => 'result_code',
        'resultMsg'    => 'result_msg',
        'txHash'       => 'tx_hash',
        'status'       => 'status',
        'registerTime' => 'register_time',
    ];

    public function validate()
    {
    }

    public function toMap()
    {
        $res = [];
        if (null !== $this->reqMsgId) {
            $res['req_msg_id'] = $this->reqMsgId;
        }
        if (null !== $this->resultCode) {
            $res['result_code'] = $this->resultCode;
        }
        if (null !== $this->resultMsg) {
            $res['result_msg'] = $this->resultMsg;
        }
        if (null !== $this->txHash) {
            $res['tx_hash'] = $this->txHash;
        }
        if (null !== $this->status) {
            $res['status'] = $this->status;
        }
        if (null !== $this->registerTime) {
            $res['register_time'] = $this->registerTime;
        }

        return $res;
    }

    /**
     * @param array $map
     *
     * @return QueryFlowPhaseResponse
     */
    public static function fromMap($map = [])
    {
        $model = new self();
        if (isset($map['req_msg_id'])) {
            $model->reqMsgId = $map['req_msg_id'];
        }
        if (isset($map['result_code'])) {
            $model->resultCode = $map['result_code'];
        }
        if (isset($map['result_msg'])) {
            $model->resultMsg = $map['result_msg'];
        }
        if (isset($map['tx_hash'])) {
            $model->txHash = $map['tx_hash'];
        }
        if (isset($map['status'])) {
            $model->status = $map['status'];
        }
        if (isset($map['register_time'])) {
            $model->registerTime = $map['register_time'];
        }

        return $model;
    }
}
