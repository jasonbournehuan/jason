<?php
/* 泛亚
  Array
    (
    [success] => 1  请求状态，1：成功；0：失败
    [msg] => 19ms   消息描述
    [info] => Array   数据
    (
        [RecordCount] => 23  记录总数
        [PageIndex] => 1  当前页
        [PageSize] => 20  每页的数据大小
        [data] =>  扩展数据
        [list] => Array  日志内容
            (
                    [0] => Array
                    (
                    [OrderID] => 2061  订单号
                    [UserName] => uhjjaavc5 下注的用户名
                    [CateID] => 2040  游戏 ID
                    [Category] => 王者荣耀 游戏名称
                    [LeagueID] => 2041 联赛 ID
                    [League] => 王者荣耀职业联赛 2018       联赛名称
                    [MatchID] => 5142 比赛 ID
                    [Match] => 王者时时乐 59880期      参与竞猜的比赛
                    [BetID] => 20868  竞猜项目 ID
                    [Bet] => 英雄性别  所参与的投注名称
                    [Content] => 女 投注内容
                    [Result] => 男 开奖结果（如未开奖则为空）
                    [BetAmount] => 10.0000  投注金额
                    [BetMoney] => 10.0000 有效投注金额
                    [Money] => -10.0000 盈亏
                    [Status] => Lose  订单状态
                                        None 等待开奖
                                        Revoke 退回本金
                                        Win 赢
                                        Lose 输
                                        WinHalf 赢一半
                                        LoseHalf 输一半
                                        Settlement 结算中（比赛已开出结果,等待派奖）
                                        Cancel 比赛取消
                    [CreateAt] => 2019/7/1 16:39:11 投注的时间
                    [UpdateAt] => 2019/7/1 16:39:40 状态最新更改的时间
                    [StartAt] => 2018/6/27 0:00:00  比赛的开始时间
                    [EndAt] => 1900/1/1 0:00:00 比赛的结束时间
                    [ResultAt] => 2019/7/1 16:39:30 结果产生时间
                    [RewardAt] => 2019/7/1 16:39:31  结算时间
                    [Odds] => 2.6659  赔率（4 位小数）
                    [IP] => 103.78.243.173  IP
                    )
            )
    )
)

api_761
   Array (
                                  [code] => 0  值为 0 时表示成功,非 0 表示失败,详见错误码及全局错误码
                                  [m] =>    code 非 0 时的提示信息,为 0 时是空字符
                                  [d] => Array
                                      (
                                          [curpage] => 1  当前页
                                          [data] => Array
                                      (
                                          [0] => Array
                                          (
                                                  [stime] => 2019-07-02 11:10:59  开始时间
                                                  [logid] => 3.5918650692076E+16   记录标识，当月惟一，跨月会重复
                                                  [award] => 0  派彩(1 元=10000)
                                                  [ctime] => 2019-07-02 11:11:34   结束时间
                                                  [prev] => 2097175  变化之前携带金额(1 元=10000)
                                                  [sessionid] => 25dcce8215620370596075 牌局编号,不惟一
                                                  [why] => Array
                                                              (
                                                                  [cliplist] => Array  :已方押注详情，依次对应飞禽、走兽、鲨鱼、燕子、鸽子、
                      孔雀、老鹰、狮子、熊猫、猴子、兔子共 11 个区域的押注，int 数组
                                                                          (
                                                                              [0] => 0
                                                                              [1] => 0
                                                                              [2] => 0
                                                                              [3] => 0
                                                                              [4] => 0
                                                                              [5] => 0
                                                                              [6] => 0
                                                                              [7] => 1000000
                                                                              [8] => 1000000
                                                                              [9] => 0
                                                                              [10] => 0

                                                                          )

                                                                  [score] => -2000000  输赢的钱,1 元=10000，bigint 类型
                                                                  [prev] => 97175  当前金币,1 元=10000，bigint 类型
                                                                  [areawin] => Array  已方各区域输赢详情，依次对应飞禽、走兽、鲨鱼、燕子、
                      鸽子、孔雀、老鹰、狮子、熊猫、猴子、兔子共 11 个区域的押注，int 数组
                                                                        (
                                                                              [0] => 0
                                                                              [1] => 0
                                                                              [2] => 0
                                                                              [3] => 0
                                                                              [4] => 0
                                                                              [5] => 0
                                                                              [6] => 0
                                                                              [7] => -1000000
                                                                              [8] => -1000000
                                                                              [9] => 0
                                                                              [10] => 0
                                                                        )

                                                                  [Block] => 24  中奖位置，int 类型
                                                                  [left] => -1902825  结算后金币,1 元=10000，bigint 类型
                                                             )

                                                  [uid] => 265721   用户 ID
                                                  [tax] => 60000  税收(1 元=10000).注捕鱼,飞禽是隐藏税收,不应该对外展示
                                                  [acc] => uhjjaavc5  账号
                                                  [left] => 97175  操作之后剩余金额(1 元=10000)
                                                  [chg] => -2000000  本次操作的变化金额(1 元=10000)
                                                  [kind] => 65003    类型,参考 loadkind 返回数据
                                                  [realput] => 2000000   有效投注(1 元=10000)
                                                  [allput] => 2000000   总投注(1 元=10000)
                                                      )
                                            [4] => Array
                                              (
                                                  [stime] => 2019-07-02 11:08:17
                                                  [logid] => 3.59184439779E+16
                                                  [award] => 0
                                                  [ctime] => 2019-07-02 11:08:17
                                                  [prev] => 97175
                                                  [sessionid] => 1156-115620190702110816281uhjjaavc5
                                                  [why] => Array
                                                      (
                                                          [money] => 3000
                                                          [opagent] => 1156
                                                          [agent] => 1156
                                                          [name] => 上分
                                                          [uid] => 265721
                                                          [chg] => 30000000
                                                      )

                                                  [uid] => 265721
                                                  [tax] => 0
                                                  [acc] => uhjjaavc5
                                                  [left] => 30097175
                                                  [chg] => 30000000
                                                  [kind] => 1
                                                  [realput] => 0
                                                  [allput] => 0
                                              )



                                        )

                                          [total] => 38   总记录条数
                                      )

                          )
fg3
Array
                               (
                                   [code] => 0  状态
                           [data] => Array
                               (
                                   [data] => Array
                                   (
                                       [0] => Array
                                       (
                                                   [agent_uid] => 1253 代理商 id
                                                   [all_bets] => 1  总投注(poker 对应后台的是有效打码)
                                                   [all_wins] => 9.55  总奖金
                                                   [currency] => CNY  货币代码
                                                   [device] => 1  设备类型 1->PC 2-> IOS 横 3->IOS 竖 4-> android 横，5->android 竖，6->其他横,7->其他竖
                                                   [end_chips] => 108.55  结束筹码
                                                   [game_id] => 6501  游戏 id
                                                   [gt] => poker  游戏类型代码(fish,slot,fruit,poker)
                                                   [id] => 65013649  局 id
                                                   [ip] => 0.0.0.0
                                                   [jackpot_bonus] => 0  jackpot 奖金保留４位小数(该奖金由 FG 出,不算入结算
                                                   [jp_contri] => 0  JP 贡献保留４位小数(当前记录下注的额度抽取进入 jackpot,一般抽取比例是千分三,单位元)
                                                   [player_name] => jhpggzvtk  玩家名称
                                                   [result] => 8.55  all_wins-all_bets(对应后台的收支)
                                                   [time] => 1555247494  注单结束时间 10 位时间戳
                                                   [total_agent_uid] => 1253  总代理商 id
                                               )

                                       )

                                   [page_key] => g2gCbgcAzN9FSn2GBW0AAAAINjUwMTM2NTA 分页码
                               )

                           [msg] => success
)
fg2
  Array
                                 (
                                     [code] => 0  状态
                             [data] => Array
                                 (
                                     [data] => Array
                                     (
                                         [0] => Array
                                         (
                                                     [agent_uid] => 1253 代理商 id
                                                     [all_bets] => 1  总投注(poker 对应后台的是有效打码)
                                                     [all_wins] => 9.55  总奖金
                                                     [currency] => CNY  货币代码
                                                     [device] => 1  设备类型 1->PC 2-> IOS 横 3->IOS 竖 4-> android 横，5->android 竖，6->其他横,7->其他竖
                                                     [end_chips] => 108.55  结束筹码
                                                     [game_id] => 6501  游戏 id
                                                     [gt] => poker  游戏类型代码(fish,slot,fruit,poker)
                                                     [id] => 65013649  局 id
                                                     [ip] => 0.0.0.0
                                                     [jackpot_bonus] => 0  jackpot 奖金保留４位小数(该奖金由 FG 出,不算入结算
                                                     [jp_contri] => 0  JP 贡献保留４位小数(当前记录下注的额度抽取进入 jackpot,一般抽取比例是千分三,单位元)
                                                     [player_name] => jhpggzvtk  玩家名称
                                                     [result] => 8.55  all_wins-all_bets(对应后台的收支)
                                                     [time] => 1555247494  注单结束时间 10 位时间戳
                                                     [total_agent_uid] => 1253  总代理商 id
                                                 )

                                         )

                                     [page_key] => g2gCbgcAzN9FSn2GBW0AAAAINjUwMTM2NTA 分页码
                                 )

                             [msg] => success
                         )
fg1
      Array
                               (
                                   [code] => 0  状态
                           [data] => Array
                               (
                                   [data] => Array
                                   (
                                       [0] => Array
                                       (
                                                   [agent_uid] => 1253 代理商 id
                                                   [all_bets] => 1  总投注(poker 对应后台的是有效打码)
                                                   [all_wins] => 9.55  总奖金
                                                   [currency] => CNY  货币代码
                                                   [device] => 1  设备类型 1->PC 2-> IOS 横 3->IOS 竖 4-> android 横，5->android 竖，6->其他横,7->其他竖
                                                   [end_chips] => 108.55  结束筹码
                                                   [game_id] => 6501  游戏 id
                                                   [gt] => poker  游戏类型代码(fish,slot,fruit,poker)
                                                   [id] => 65013649  局 id
                                                   [ip] => 0.0.0.0
                                                   [jackpot_bonus] => 0  jackpot 奖金保留４位小数(该奖金由 FG 出,不算入结算
                                                   [jp_contri] => 0  JP 贡献保留４位小数(当前记录下注的额度抽取进入 jackpot,一般抽取比例是千分三,单位元)
                                                   [player_name] => jhpggzvtk  玩家名称
                                                   [result] => 8.55  all_wins-all_bets(对应后台的收支)
                                                   [time] => 1555247494  注单结束时间 10 位时间戳
                                                   [total_agent_uid] => 1253  总代理商 id
                                               )

                                       )

                                   [page_key] => g2gCbgcAzN9FSn2GBW0AAAAINjUwMTM2NTA 分页码
                               )

                           [msg] => success
                       )

ky
          Array
                                             (
                                [m] => /getRecordHandle  主操作类型
                                [s] => 106  子操作类型
                                [d] => Array  数据结果
                                         (
                                        [code] => 0  错误码（查看附录说明
                                        [start] => 1561793450000  数据拉取开始时间
                                        [end] => 1561797684000 数据拉取结束时间
                                        [count] => 22  返回列表行数
                                        [list] => Array  数据列表
                                         (
                                             [0] => Array
                                             (
                                                    [GameID] => 50-1561793857-23215876-2 游戏局号列表
                                                    [Accounts] => 70823_uhjjaavc5 玩家帐号列表
                                                    [ServerID] => 8601 房间 ID 列表
                                                    [KindID] => 860 游戏 ID 列表(对应游戏见附录)
                                                    [TableID] => 172020001  桌子号列表
                                                    [ChairID] => 2 椅子号列表
                                                    [UserCount] => 5 玩家数量列表
                                                    [CellScore] => 10.00 有效下注
                                                    [AllBet] => 10.00 总下注列表
                                                    [Profit] => 9.50 盈利列表
                                                    [Revenue] => 0.50 抽水列表
                                                    [GameStartTime] => 2019-06-29 15:37:37 游戏开始时间列表
                                                    [GameEndTime] => 2019-06-29 15:37:58 游戏结束时间列表
                                                    [CardValue] => 2733111b29091c25022818263b0b325 手牌公共牌（读取规则见附录）
                                                    [ChannelID] => 70823 渠道 ID 列表
                                                    [LineCode] => 70823_1 游戏结果对应玩家所属站点
                                              )

                                        )

                                )

                        )


bbin1
        接口返回的原始数据  Array
        (
        [result] => 1   true or  false
        [data] => Array   返回的集
        (
            [0] => Array
                (
                    [UserName] => uhjjaavc5 帐号
                    [WagersID] => 407899325681 注单号码
                    [WagersDate] => 2019-07-03 02:33:15 下注时间
                    [GameType] => 5010  游戏种类
                    [Result] => 200  注单结果
-1：注销、1：赢、200：输、0：未结算
                    [BetAmount] => 25.0  下注金额
                    [Commissionable] => 24.99 会员有效投注额
                    [Payoff] => -25    派彩金额
                    [Currency] => RMB 币别
                    [ExchangeRate] => 1.000000  与人民币的汇率
                )

            [1] => Array
                (
                    [UserName] => uhjjaavc5
                    [WagersID] => 407899336861
                    [WagersDate] => 2019-07-03 02:33:17
                    [GameType] => 5010
                    [Result] => 1
                    [BetAmount] => 25.0
                    [Commissionable] => 24.99
                    [Payoff] => 64
                    [Currency] => RMB
                    [ExchangeRate] => 1.000000
                )


        )

        [pagination] => Array
        (
            [Page] => 1
            [PageLimit] => 500
            [TotalNumber] => 49
            [TotalPage] => 1
        )

)
bbin2
   接口返回的原始数据  Array
        (
        [result] => 1   true or  false
        [data] => Array   返回的集
        (
            [0] => Array
                (
                    [UserName] => uhjjaavc5 帐号
                    [WagersID] => 407899325681 注单号码
                    [WagersDate] => 2019-07-03 02:33:15 下注时间
                    [GameType] => 5010  游戏种类
                    [Result] => 200  注单结果
-1：注销、1：赢、200：输、0：未结算
                    [BetAmount] => 25.0  下注金额
                    [Commissionable] => 24.99 会员有效投注额
                    [Payoff] => -25    派彩金额
                    [Currency] => RMB 币别
                    [ExchangeRate] => 1.000000  与人民币的汇率
                )

            [1] => Array
                (
                    [UserName] => uhjjaavc5
                    [WagersID] => 407899336861
                    [WagersDate] => 2019-07-03 02:33:17
                    [GameType] => 5010
                    [Result] => 1
                    [BetAmount] => 25.0
                    [Commissionable] => 24.99
                    [Payoff] => 64
                    [Currency] => RMB
                    [ExchangeRate] => 1.000000
                )


        )

        [pagination] => Array
        (
            [Page] => 1
            [PageLimit] => 500
            [TotalNumber] => 49
            [TotalPage] => 1
        )

)

bbin1_3
      Array
        (
        [result] => 1   true or  false
        [data] => Array   返回的集
        (
            [0] => Array
                (
                    [UserName] => uhjjaavc5 帐号
                    [WagersID] => 407899325681 注单号码
                    [WagersDate] => 2019-07-03 02:33:15 下注时间
                    [GameType] => 5010  游戏种类
                    [Result] => 200  注单结果
-1：注销、1：赢、200：输、0：未结算
                    [BetAmount] => 25.0  下注金额
                    [Commissionable] => 24.99 会员有效投注额
                    [Payoff] => -25    派彩金额
                    [Currency] => RMB 币别
                    [ExchangeRate] => 1.000000  与人民币的汇率
                )

            [1] => Array
                (
                    [UserName] => uhjjaavc5
                    [WagersID] => 407899336861
                    [WagersDate] => 2019-07-03 02:33:17
                    [GameType] => 5010
                    [Result] => 1
                    [BetAmount] => 25.0
                    [Commissionable] => 24.99
                    [Payoff] => 64
                    [Currency] => RMB
                    [ExchangeRate] => 1.000000
                )


        )

        [pagination] => Array
        (
            [Page] => 1
            [PageLimit] => 500
            [TotalNumber] => 49
            [TotalPage] => 1
        )

)
bbin1_5
Array
        (
        [result] => 1   true or  false
        [data] => Array   返回的集
        (
            [0] => Array
                (
                    [UserName] => uhjjaavc5 帐号
                    [WagersID] => 407899325681 注单号码
                    [WagersDate] => 2019-07-03 02:33:15 下注时间
                    [GameType] => 5010  游戏种类
                    [Result] => 200  注单结果
-1：注销、1：赢、200：输、0：未结算
                    [BetAmount] => 25.0  下注金额
                    [Commissionable] => 24.99 会员有效投注额
                    [Payoff] => -25    派彩金额
                    [Currency] => RMB 币别
                    [ExchangeRate] => 1.000000  与人民币的汇率
                )

            [1] => Array
                (
                    [UserName] => uhjjaavc5
                    [WagersID] => 407899336861
                    [WagersDate] => 2019-07-03 02:33:17
                    [GameType] => 5010
                    [Result] => 1
                    [BetAmount] => 25.0
                    [Commissionable] => 24.99
                    [Payoff] => 64
                    [Currency] => RMB
                    [ExchangeRate] => 1.000000
                )


        )

        [pagination] => Array
        (
            [Page] => 1
            [PageLimit] => 500
            [TotalNumber] => 49
            [TotalPage] => 1
        )

)
bbin5
  Array
        (
        [result] => 1   true or  false
        [data] => Array   返回的集
        (

            [0] => Array
                (
                    UserName] => uhjjaavc5  帐号
                    [WagersID] => 22838113360  注单号码
                    [WagersDate] => 2019-07-24 07:16:32 下注时间
                    [SerialID] => 147113547  局号
                    [RoundNo] => 7-24  场次
                    [GameType] => 3018  游戏种类
                    [WagerDetail] => 8,1:7,10.00,-10.00*16,1:8,10.00,-10.00*32,1:100,10.00,-10.00*64,1:120,10.00,-10.00     玩法
                    [GameCode] => 1    桌号
                    [Result] => HighCard-A,HighCard-10   开牌结果
                    [Card] => C.1,S.4,H.9*C.10,H.8,S.2   结果牌
                    [BetAmount] => 40 下注金额
                    [Origin] => P   1.行动装置下单：M
1-1.ios手机：MI1
1-2.ios平板：MI2
1-3.Android手机：MA1
1-4.Android平板：MA2
2.计算机下单：P
                    [Commissionable] => 40   会员有效投注额
                    [Payoff] => -40  派彩金额
                    [Currency] => RMB  币别
                    [ExchangeRate] => 1.000000  与人民币的汇率
                    [ResultType] =>         注单结果 -1：注销、0：未结算
                )


        )

        [pagination] => Array
        (
            [Page] => 1  页数
            [PageLimit] => 500  每页数量
            [TotalNumber] => 49    总数
            [TotalPage] => 1    总页数
        )

)
bbin6
 Array
        (
        [result] => 1   true or  false
        [data] => Array   返回的集
        (
            [0] => Array
                (
                    [UserName] => uhjjaavc5 帐号
                    [WagersID] => 407899325681 注单号码
                    [WagersDate] => 2019-07-03 02:33:15 下注时间
                    [GameType] => 5010  游戏种类
                    [Result] => X  注单结果(N:已取消,X:未结算,W:赢,L:输,LW:赢一半,LL:输一半,0:平手,S:等待
中,D:未接受,C:注销, F:非法下注,SC:系统注销,DC:危险球注销)
                    [BetAmount] => 25.0  下注金额
                    [Commissionable] => 24.99 会员有效投注额
                    [Payoff] => -25    派彩金额
                    [Currency] => RMB 币别
                    [ExchangeRate] => 1.000000  与人民币的汇率
                    [Origin] => P   1.行动装置下单：M
1-1.ios手机：MI1
1-2.ios平板：MI2
1-3.Android手机：MA1
1-4.Android平板：MA2
2.计算机下单：P
                    [UPTIME] => 2019-07-25 10:17:58  注单变更时间
                    [OrderDate] => 2019-07-25  赛事时间
                    [PayoutTime] => 2019-07-25  结算时间
                    [AccountDate] => 2019-07-25  帐务时间
                )

        )

        [pagination] => Array
        (
            [Page] => 1
            [PageLimit] => 500
            [TotalNumber] => 49
            [TotalPage] => 1
        )

)
bbin631
    Array
        (
        [result] => 1   true or  false
        [data] => Array   返回的集
        (
            [0] => Array
                (
                    [UserName] => uhjjaavc5 帐号
                    [WagersID] => 407899325681 注单号码
                    [WagersDate] => 2019-07-03 02:33:15 下注时间
                    [GameType] => 5010  游戏种类
                    [Result] => X  注单结果(0:等待结果, 1:注单异动时的中继状态, 2:平手/取消, 3:输, 4:赢, 5:
无结果取消, -1:无效注单)
                    [BetAmount] => 25.0  下注金额
                    [Commissionable] => 24.99 会员有效投注额
                    [Payoff] => -25    派彩金额
                    [Currency] => RMB 币别
                    [ExchangeRate] => 1.000000  与人民币的汇率
                    [Origin] => P1 .0:网页、1:手机、2:ios、3:安卓
                    [UPTIME] => 2019-07-25 10:17:58  注单变更时间(action=ModifiedTime时，才会回传)
                    [OrderDate] => 2019-07-25  帐务时间(action=ModifiedTime时，才会回传)
                )

        )

        [pagination] => Array
        (
            [Page] => 1
            [PageLimit] => 500
            [TotalNumber] => 49
            [TotalPage] => 1
        )

)

bbin38
   Array
        (
        [result] => 1   true or  false
        [data] => Array   返回的集
        (
            [0] => Array
                (
                  UserName] => uhjjaavc5  帐号
                    [WagersID] => 1010246528   注单号码
                    [WagersDate] => 2019-07-27 01:28:36  下注时间
                    [GameType] => 38001  游戏种类
                    [Result] => W  注单结果(C:注销,W:赢,L:输)
                    [SerialID] => 13127437  局号
                    [BetAmount] => 960.00   下注金额
                    [Payoff] => -460.00   派彩金额
                    [Currency] => RMB  币别
                    [ExchangeRate] => 1  与人民币的汇率
                    [Commissionable] => 960   会员有效投注额
                    [ModifiedDate] => 2019-07-27 01:28:36   注单变更时间
                )

        )

        [pagination] => Array
        (
            [Page] => 1
            [PageLimit] => 500
            [TotalNumber] => 49
            [TotalPage] => 1
        )

)
bbin30
     Array
        (
        [result] => 1   true or  false
        [data] => Array   返回的集
        (
            [0] => Array
                (
                  UserName] => uhjjaavc5  帐号
                    [WagersID] => 1010246528   注单号码
                    [WagersDate] => 2019-07-27 01:28:36  下注时间
                    [GameType] => 38001  游戏种类
                    [Result] => W  注单结果(C:注销,W:赢,L:输)
                    [SerialID] => 13127437  局号
                    [BetAmount] => 960.00   下注金额
                    [Payoff] => -460.00   派彩金额
                    [Currency] => RMB  币别
                    [ExchangeRate] => 1  与人民币的汇率
                    [Commissionable] => 960   会员有效投注额
                    [ModifiedDate] => 2019-07-27 01:28:36   注单变更时间
                )

        )

        [pagination] => Array
        (
            [Page] => 1
            [PageLimit] => 500
            [TotalNumber] => 49
            [TotalPage] => 1
        )

)

bbin8
   Array
        (
        [result] => 1   true or  false
        [data] => Array   返回的集
        (


            [1] => Array
                (
                    [UserName] => uhjjaavc5 帐号
                    [WagersID] => 12335533461 注单号码
                    [WagersDate] => 2019-07-03 11:36:59  下注时间
                    [GameType] => B1SC  游戏种类
                    [Result] => W   注单结果
W：赢
L：输
N：平手
0：没有结果
N2：注销
                    [BetAmount] => 5.00  下注金额
                    [Payoff] => 4.80  派彩金额
                    [Currency] => RMB  币别
                    [ExchangeRate] => 1.00000000  与人民币的汇率
                    [Commission] => 0.00  退水
                    [IsPaid] => Y  Y：已派彩、N：未派彩
                    [Origin] => P 1.行动装置下单：M
1-1.ios手机：MI1
1-2.ios平板：MI2
1-3.Android手机：MA1-4.Android平板：MA2.计算机下单：P
                    [GameNum] => 20190703-710  期数
                )


        )

        [pagination] => Array
        (
            [Page] => 1
            [PageLimit] => 500
            [TotalNumber] => 49
            [TotalPage] => 1
        )

)

bbin8_1
   Array
        (
        [result] => 1   true or  false
        [data] => Array   返回的集
        (


            [1] => Array
                (
                    [UserName] => uhjjaavc5 帐号
                    [WagersID] => 12335533461 注单号码
                    [WagersDate] => 2019-07-03 11:36:59  下注时间
                    [GameType] => B1SC  游戏种类
                    [Result] => W   注单结果
W：赢
L：输
N：平手
0：没有结果
N2：注销
                    [BetAmount] => 5.00  下注金额
                    [Payoff] => 4.80  派彩金额
                    [Currency] => RMB  币别
                    [ExchangeRate] => 1.00000000  与人民币的汇率
                    [Commission] => 0.00  退水
                    [IsPaid] => Y  Y：已派彩、N：未派彩
                    [Origin] => P 1.行动装置下单：M
1-1.ios手机：MI1
1-2.ios平板：MI2
1-3.Android手机：MA1-4.Android平板：MA2.计算机下单：P
                    [GameNum] => 20190703-710  期数
                )


        )

        [pagination] => Array
        (
            [Page] => 1
            [PageLimit] => 500
            [TotalNumber] => 49
            [TotalPage] => 1
        )

)
bg1
  Array
(
    [id] =>
    [result] => Array
        (
            [total] => 389                            //总条数
            [stats] => Array                         //查询出统计数据
                (
                    [totalPageBet] => 0.45           //小计投注扣款额
                    [totalPageUserCount] => 1        //小计总用户数
                    [totalUserCount] => 1            //总用户数
                    [totalProfit] => -79.4
                    [totalPageWin] => 0              //小计派彩入款
                    [totalPageProfit] => -0.45
                    [totalBet] => 233.1              //总投注扣款额
                    [totalWin] => 152.7              //总派彩入款
                )

            [page] => 1                           //当前查询页码
            [items] => Array                     //查询出列表数据
                (
                    [0] => Array
                        (
                            [transactionId] => 2091441033-f0ddcf      //交易Id
                            [cTransactionId] => 2091441034-ba2888
                            [sn] => am00                              //厅代码
                            [userId] => 111698761                     //用户ID
                            [loginId] => uhjjaagj2                    //会员登录ID
                            [bet] => 0.45                             //投注扣款额
                            [win] => 0                                //派彩入款
                            [action] => debit
                            [cAction] => credit
                            [actionType] => BET
                            [cActionType] => WIN
                            [gameId] => 93                            //游戏Id
                            [roundId] => 1039340479                   //订单Id
                            [betTimeBj] => 2019-08-16 22:16:33        //下注北京时间
                            [betTimeEst] => 2019-08-16 10:16:33       //下注美东时间
                            [lastUpdateTime] => 2019-08-16 10:16:33.0 //最后修改时间
                            [status] => 2                             //注单状态:  2. 结算成功；4. 投注成功
                            [count] =>
                            [enGameName] => Emperors Wealth           //游戏英文名称
                            [cnGameName] => 皇帝的财富                 //游戏中文名称
                            [userCount] =>
                            [cBetTimeEst] => 2019-08-16 10:16:33      //结算美东时间
                            [cBetTimeBj] => 2019-08-16 22:16:33       //结算北京时间
                            [orderFrom] =>                            //注单来源，请参见: 终端类别
                            [profit] => -0.45
                        )

                )

        )

    [error] =>
    [jsonrpc] => 2.0
)


)
bg_fish_master
      Array
(
    [id] =>
    [result] => Array
        (
            [total] => 29                                            符合条件的总数量
            [pageIndex] => 1                                         页索引
            [stats] => Array
                (
                    [sumStat] => Array
                        (
                            [orderCount] => 1
                            [userCount] => 1
                            [betAmount] => 20600
                            [payOutAmount] => -175.6
                            [validAmount] => 20600
                            [jackpot] => 0
                            [extend] => 0
                        )

                    [subStat] => Array
                        (
                            [orderCount] => 1
                            [userCount] => 1
                            [betAmount] => 1.2
                            [payOutAmount] => -0.4
                            [validAmount] => 1.2
                            [jackpot] => 0
                            [extend] => 0
                        )

                )

            [pageSize] => 1                                    页大小
            [etag] =>
            [page] => 1
            [items] => Array                                   注单列表
                (
                    [0] => Array
                        (
                            [sn] => am00                       厅代码
                            [userId] => 111698761              用户ID
                            [loginId] => uhjjaagj2             用户登录ID
                            [issueId] => 2019081600046619      局号
                            [betId] => 190816095941000001      注单号
                            [gameBalance] => 13.30
                            [fireCount] => 12                  发炮数量
                            [betAmount] => 1.2                 下注额
                            [validAmount] => 1.2               有效投注
                            [calcAmount] => 0.8                结算金额
                            [payout] => -0.4                   派彩(输赢)
                            [orderTime] => 2019-08-16 09:59:41 下注时间(UTC-4)
                            [orderFrom] => 1                   注单来源，请参见: 终端类别
                            [jackpot] => 0                     JP中奖
                            [extend] => 0                      JP预抽
                            [jackpotType] => 0                 奖池类型，默认为0(默认值为0，即打中宝箱并获得彩金)
                            [gameType] => 105                  仅限查询条件中指定gameType为1时有效105: BG捕鱼大师; 411: 西游捕鱼
                        )

                )

        )

    [error] =>
    [jsonrpc] => 2.0
)
bg_westward_fish
       Array
(
    [id] =>
    [result] => Array
        (
            [total] => 29                                            符合条件的总数量
            [pageIndex] => 1                                         页索引
            [stats] => Array
                (
                    [sumStat] => Array
                        (
                            [orderCount] => 1
                            [userCount] => 1
                            [betAmount] => 20600
                            [payOutAmount] => -175.6
                            [validAmount] => 20600
                            [jackpot] => 0
                            [extend] => 0
                        )

                    [subStat] => Array
                        (
                            [orderCount] => 1
                            [userCount] => 1
                            [betAmount] => 1.2
                            [payOutAmount] => -0.4
                            [validAmount] => 1.2
                            [jackpot] => 0
                            [extend] => 0
                        )

                )

            [pageSize] => 1                                    页大小
            [etag] =>
            [page] => 1
            [items] => Array                                   注单列表
                (
                    [0] => Array
                        (
                            [sn] => am00                       厅代码
                            [userId] => 111698761              用户ID
                            [loginId] => uhjjaagj2             用户登录ID
                            [issueId] => 2019081600046619      局号
                            [betId] => 190816095941000001      注单号
                            [gameBalance] => 13.30
                            [fireCount] => 12                  发炮数量
                            [betAmount] => 1.2                 下注额
                            [validAmount] => 1.2               有效投注
                            [calcAmount] => 0.8                结算金额
                            [payout] => -0.4                   派彩(输赢)
                            [orderTime] => 2019-08-16 09:59:41 下注时间(UTC-4)
                            [orderFrom] => 1                   注单来源，请参见: 终端类别
                            [jackpot] => 0                     JP中奖
                            [extend] => 0                      JP预抽
                            [jackpotType] => 0                 奖池类型，默认为0(默认值为0，即打中宝箱并获得彩金)
                            [gameType] => 105                  仅限查询条件中指定gameType为1时有效105: BG捕鱼大师; 411: 西游捕鱼
                        )

                )

        )

    [error] =>
    [jsonrpc] => 2.0
)
bg5
   Array
(
    [id] =>
    [result] => Array
        (
            [total] => 7  符合条件的总数量
            [pageIndex] => 1  页索引
            [stats] => Array
                (
                    [validAmountTotal] => 200
                    [aAmountTotal] => 266.9
                    [userCount] => 1
                    [paymentTotal] => 66.9
                    [bAmountTotal_] => 200
                    [bAmountTotal] => -200
                    [validBetTotal] => 150
                    [paymentTotal_] => 66.9
                )
            [pageSize] => 500  页大小
            [etag] =>    ETag标记(缓存加速)
            [page] => 1  当前页
            [items] => Array   注单列表
                (
                    [0] => Array
                        (
                            [tranId] =>                               订单ID
                            [aAmount] => 50                          结算额
                            [loginId] => uhjjaagj2                   用户登录ID
                            [orderId] => 5445969060                  订单ID
                            [moduleName] => 视讯                      模块名称
                            [orderStatus] => 3                       注单状态
                                                                     0	注单不存在	仅对免转模式有效
                                                                     1	未结算	新注单
                                                                     2	结算赢	正常结算
                                                                     3	结算和	正常结算
                                                                     4	结算输	正常结算
                                                                     5	取消	用户取消
                                                                     6	过期
                                                                     7	系统取消
                            [playId] => 268435457                    玩法ID，唯一标识一种注单类别
                            [uid] => 111698761                       用户ID
                            [orderTime] => 2019-08-17 07:28:59       下注时间
                            [gameName] => 百家乐                      游戏名称
                            [payment] => 0                           派彩(输赢)
                            [sn] => am00                             厅代码
                            [bAmount] => -50                         下注额
                            [moduleId] => 2                          模块ID
                            [noComm] => 0
                            [gameId] => 1                           游戏ID，请参见: 视讯游戏类别 (CODE)
                            [playNameEn] => Banker                  玩法名称(En)
                            [issueId] => BGA01190817213             下注期数
                            [playName] => 下注庄赢                   玩法名称
                            [userId] => 111698761                   用户ID
                            [gameNameEn] => Baccarat                游戏名称(En)
                            [fromIp] => 103.119.129.73              下注来源IP
                            [orderFrom] => 1                        订单来源，请参见: BG视讯终端类别
                            [validBet] => 0                        打码量(有效投注)
                            [betContent] => 0,0
                            [lastUpdateTime] => 2019-08-17 07:29:24  最后修改时间
                        )
                )
        )
    [error] =>
    [jsonrpc] => 2.0
)


)

ug6
   Array
(
    [errcode] => 000000
    [errtext] => Array
        (
        )

    [result] => Array
        (
            [bet] => Array
                (
                    [0] => Array
                        (
                            [BetID] => SP267173343               注单号
                            [GameID] => 1                         游戏编号 ( 1 = 体育)
                            [SubGameID] => 4                     子游戏编号  (子游戏编号于SportID 一样)
(此编号可以查询 Sport&BetPosition(v1.1))
                            [Account] => uhjjaagj2               会员账号
                            [BetAmount] => 10.0000               下注金额
                            [BetOdds] => -0.9200                 投注赔率
                            [AllWin] => 10.0000                  全赢
                            [DeductAmount] => 9.2000             扣款金额 ( 扣除投注金额)
                            [BackAmount] => 0.0000               退还金额
                            [Win] => 0.0000                      赢输 (负数 = 输 / 正数=赢)
                            [Turnover] => 0.0000                 有效投注金额
                            [OddsStyle] => MY                    赔率样式
                            [BetDate] => 2019-08-22 14:50:21     投注时间
                            [Status] => 1                        投注状态 (返回)
                                                                 0 = 等待
                                                                 1 = 接受
                                                                 2 = 结算
                                                                 3 = 取消
                                                                 4 = 拒绝
                            [Result] => Array                    注单结果0 = 和 1 = 全赢 2 = 全输 3 = 赢半 4 = 输半
                                (
                                )
                            [ReportDate] => 2019-08-22 00:00:00   注单报表时间
                            [BetIP] => 103.119.129.73             投注IP
                            [UpdateTime] => 2019-08-22 14:50:24   注单更新时间
                            [BetInfo] => [{"SubID":179606890,"SportID":4,"LeagueID":5623,"MatchID":2115391,"HomeID":39178,"AwayID":39193,"Stage":2,"MarketID":1,"Odds":-0.92,"Hdp":1.0,"HomeScore":0,"AwayScore":0,"HomeCard":0,"AwayCard":0,"BetPos":2,"OutLevel":0.0}]                                      投注内容
                            [BetResult] => {"MatchIDList":[2115391],"InsuranceList":[],   "BetStatusDic":{"179606890":{"BetID":267173343,"SubID":179606890,"Result":0,"Status":1}}}     投注结果
此内容里面的InsuranceList":[] , []之间有参数代表注单使保险功能
                            [BetType] => 1                       玩法 BetType和 Betinfo 里面的MarketID 是一样. 请查询文档 Sport&BetPosition(v1.1)
                            [BetPos] => 2                        投注位置  请查询文档 Sport&BetPosition(v1.1)
                            [AgentID] => 0                       代理编号
                            [SortNo] => 44649253                 排序编号
                        )
                )
        )
)

cq9

Array
(
    [data] => Array
        (
            [TotalSize] => 65                                               總筆數
            [Data] => Array
                (
                    [0] => Array
                        (
                            [gamehall] => cq9                               遊戲商名稱
                            [gametype] => slot                              遊戲種類 
                            [gameplat] => web                               遊戲平台
                            [gamecode] => 123                               遊戲代碼
                            [account] => uhjjaagj2                          玩家帳號
                            [round] => 327412813203                         遊戲局號
                            [balance] => 189.15                             遊戲後餘額
                            [win] => 0                                      遊戲贏分（已包含彩池獎金及從PC贏得的金額）
                            [bet] => 11                                     下注金額
                            [jackpot] => 0                                  彩池獎金
                            [winpc] => 0                                    從PC贏得的金額，詳細說明請參考API-注意事項第7點※此欄位為牌桌遊戲使用 
                            [jackpotcontribution] => Array                  彩池獎金貢獻值 ※從小彩池到大彩池依序排序
                                (
                                )

                            [jackpottype] =>                                彩池獎金類別 ※此欄位值為空字串時，表示未獲得彩池獎金
                            [status] => complete                            注單狀態 [complete]complete:完成 
                            [endroundtime] => 2019-08-31T08:42:56.978-04:00 遊戲結束時間，格式為 RFC3339
                            [createtime] => 2019-08-31T08:42:56-04:00       當筆資料建立時間，格式為 RFC3339 ※系統結算時間, 注單結算時間及報表結算時間都是createtime
                            [bettime] => 2019-08-31T08:42:53-04:00          下注時間，格式為 RFC3339
                            [detail] => Array                               回傳 free game / bonus game / luckydraw / item / reward 資訊
                                                                            ※slot 會回傳 free game / bonus game / luckydraw 資訊
                                                                            ※fish 會回傳 item / reward 資訊
                                                                            ※table 會回傳空陣列     
                                (
                                    [0] => Array
                                        (
                                            [freegame] => 0
                                        )

                                    [1] => Array
                                        (
                                            [luckydraw] => 0
                                        )

                                    [2] => Array
                                        (
                                            [bonus] => 0
                                        )

                                )

                            [singlerowbet] =>                 [true|false]是否為再旋轉形成的注單
                            [gamerole] =>                     庄(banker) or 閒(player)※此欄位為牌桌遊戲使用，非牌桌遊戲此欄位值為空字串
                            [bankertype] =>                   對戰玩家是否有真人[pc|human]
                                                              pc：對戰玩家沒有真人
                                                              human：對戰玩家有真人
                                                              ※此欄位為牌桌遊戲使用，非牌桌遊戲此欄位值為空字串
                                                              ※如果玩家不支持上庄，只存在與系统對玩。則bankertype 為 PC
                            [rake] => 0                       抽水金額※此欄位為牌桌遊戲使用
                        )

                )

        )

    [status] => Array
        (
            [code] => 0
            [message] => Success
            [datetime] => 2019-08-31T08:45:05-04:00
            [traceCode] => bzNTcKqJQf
        )

)

jdb
Array
(
    [status] => 0000
    [data] => Array
        (
            [0] => Array
                (
                    [seqNo] => 7282785053667                              游戏序号.
                    [playerId] => uhjjaagj2                               玩家账号
                    [gType] => 0                                          游戏型态 
                    [mtype] => 8014                                       机台类型(请参考「JDB Games.pdf」)
                    [gameDate] => 06-09-2019 03:17:30                     游戏日期 (dd-MM-yyyy HH:mm:ss)
                    [bet] => -0.3                                         老虎机押注金额
                    [win] => 0                                            游戏赢分
                    [total] => -0.3                                       总输赢
                    [currency] => RB                                      货币别 参照附录「货币代码」
                    [jackpot] => 0                                        赢得彩金金额             
                    [jackpotContribute] => 0                              彩金贡献值
                    [denom] => 0.01                                       投注面值
                    [lastModifyTime] => 06-09-2019 03:17:30               最后修改时间 (dd-MM-yyyy HH:mm:ss)      
                    [gameName] =>                                         
                    [playerIp] => 103.78.243.173                          玩家登入 IP
                    [clientType] => WEB                                   玩家从网页或行动装置登入
                    [hasFreegame] => 0                                    免费游戏 0: 否 1: 是
                    [hasGamble] => 0                                      博取游戏 0: 否 1: 是
                    [gambleBet] => 0                                      博取游戏押注金额 
                    [systemTakeWin] => 0                                  标记该笔为游戏中断线，由系统结算 0: 否 1: 是 
                )

        )

)





*/


